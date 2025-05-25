# les outils qu'on va utlisé
import time
import random
import threading #par exemple ici , threading pour lancer plusierus users en parallele
from psutil import cpu_percent, virtual_memory
import sys
from pathlib import Path

# Ajouter le dossier parent au chemin Python
sys.path.append(str(Path(__file__).parent.parent/"includes"))  # Remonte de 2 niveaux

# indexer est le fichier d'indexation qui traite la requete
from indexer import search_query, documents


# Configuration du test
SIMULATED_USERS = 50         # Nombre d'utilisateurs simultanés
QUERIES_PER_USER = 5          # Requêtes par utilisateur
TEST_QUERIES = ["restaurant", "rooftop", "sushi", "livraison", "cuisine asiatique"]

# Statistiques au début
total_requests = 0
latencies = [] #temps reponse dans une liste
errors = 0

def user_simulation(user_id): 
    global total_requests, errors
    for _ in range(QUERIES_PER_USER): #ici il choisit une requete au hasard parmi test_queries
        q = random.choice(TEST_QUERIES)
        start = time.time()
        
        try:
            # Appel de votre fonction de recherche
            results = search_query(q, documents)
            latency = time.time() - start
            latencies.append(latency)
            print(f"User {user_id:02d} | Query: '{q[:12]:<12}' | Latency: {latency:.3f}s | Results: {len(results)}")
        except Exception as e:
            errors += 1
            print(f"User {user_id:02d} | ERROR on '{q}': {str(e)}")
        
        total_requests += 1
        time.sleep(random.uniform(0.1, 0.5))  # attend un peu afin de Simuler un temps de réflexion

def monitor_resources():
    while True:
        cpu = cpu_percent() #cpu utilisé chaque deux secondes
        ram = virtual_memory().percent
        print(f"System Monitor | CPU: {cpu}% | RAM: {ram}%")
        time.sleep(2)

if __name__ == "__main__":
    print(f" Starting load test: {SIMULATED_USERS} users, {QUERIES_PER_USER} queries each")
    
    # Démarrer le monitoring
    threading.Thread(target=monitor_resources, daemon=True).start()
    
    # Démarrer les utilisateurs simulés
    threads = []
    start_test = time.time()
    
    for i in range(SIMULATED_USERS):
        t = threading.Thread(target=user_simulation, args=(i+1,))
        threads.append(t)
        t.start()
        time.sleep(0.1)  # Délai entre le démarrage des utilisateurs
    
    for t in threads:
        t.join()
    
    # Résultats finaux
    total_time = time.time() - start_test
    avg_latency = sum(latencies) / len(latencies) if latencies else 0
    
    print("\n Test Results:")
    print(f"- Total requests: {total_requests}")
    print(f"- Total time: {total_time:.2f}s")
    print(f"- Requests/sec: {total_requests/total_time:.1f}")
    print(f"- Avg latency: {avg_latency:.3f}s")
    print(f"- Max latency: {max(latencies):.3f}s" if latencies else "-")
    print(f"- Errors: {errors} ({errors/total_requests:.1%})")