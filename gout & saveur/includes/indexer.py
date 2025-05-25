import sys
import io
import pymysql
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity
import nltk
import json 


try:
    nltk.data.find('tokenizers/punkt')
except LookupError:
    nltk.download('punkt')

try:
    nltk.data.find('corpora/stopwords')
except LookupError:
    nltk.download('stopwords')

from nltk.corpus import stopwords
from nltk.tokenize import word_tokenize
from nltk.stem import PorterStemmer

# Requête reçue depuis PHP ou entrée manuelle

if len(sys.argv) > 1:
    user_query = sys.argv[1]
else:
    user_query = input("Entrer une requête : ")

# Télécharger les ressources NLTK
nltk.download('punkt')
nltk.download('stopwords')

# Connexion à la base de données
connexion = pymysql.connect(
    host="localhost",
    user="maram",
    password="ekhdemstp777",
    database="db_pfa"
)

curseur = connexion.cursor()
curseur.execute("SELECT nom, categorie, description, image_url,id_restaurant FROM restaurant")
resultats = curseur.fetchall()

# Préparation des documents et des infos restaurants
documents = []
restaurant = []

for nom, categorie, description, image_url,id_restaurant in resultats:
    doc = f"{nom} {categorie} {description}{id_restaurant}"
    documents.append(doc)
    restaurant.append({
        'id':id_restaurant,
        'nom': nom,
        'categorie': categorie,
        'description': description,
        'image_url': image_url
    })

# Fonction de prétraitement
def preprocess_text(text):
    stop_words = set(stopwords.words('french'))
    stemmer = PorterStemmer()
    tokens = word_tokenize(text.lower())
    filtered_tokens = [stemmer.stem(word) for word in tokens if word.isalpha() and word not in stop_words]
    return " ".join(filtered_tokens)

# Fonction de recherche
def search_query(query, docs):
    processed_docs = {i: preprocess_text(doc) for i, doc in enumerate(docs)}
    processed_query = preprocess_text(query)

#   print("Documents prétraités :")
 #   for i, doc in processed_docs.items():
  #      print(f"{i}: '{doc}'")

    vectorizer = TfidfVectorizer()
    tfidf_matrix = vectorizer.fit_transform(processed_docs.values())
    query_vector = vectorizer.transform([processed_query])
    similarity = cosine_similarity(query_vector, tfidf_matrix).flatten()

    ranked_indices = similarity.argsort()[::-1]
    ranked_docs = [(i, similarity[i]) for i in ranked_indices if similarity[i] > 0.1]
    return ranked_docs
sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8')
# Exécution de la recherche
results = search_query(user_query, documents) 
print("<div class='search-results'> <ul class='container'>")
for index, score in results:
    r = restaurant[index]
    print(f"""
        <a href="restaurant.php?id={r['id']}" >
        <li class='item'>
            <span id="name"><strong>{r['nom']}</strong></span>
            <img src="{r['image_url']}" alt="Image de {r['nom']}" style="width:200px;" ><br>
            <span id="cat"><strong>Catégorie :</strong> {r['categorie']}<br></span>
            <p><strong>Description :</strong> {r['description']}</p>
        </li>
        </a>
    """)
print("</ul></div>")

# Affichage des résultats
# for index, score in results:
  #  r = restaurant[index]
   # print(f"Nom: {r['nom']}")
    #print(f"Catégorie: {r['categorie']}")
    #print(f"Description: {r['description']}")
    #print(f"{r['image_url']}")
   # print(f"Score de similarité: {score:.2f}")
   # print("-" * 50)
