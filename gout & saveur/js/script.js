let animationDone = false; // Variable pour suivre l'état de l'animation
const searchInput = document.getElementById("searchInput");
searchInput.addEventListener("keydown", function (e) {
  if (e.key === "Enter" && this.value.trim() !== "") {
    const keyword = this.value.trim();

    // Animate transition
    const background = document.getElementById("mainBackground");
    background.classList.add("slide-up");

    setTimeout(() => {
      background.style.display = "none";
      background.classList.remove("slide-up");
      document.getElementById("results").style.display = "block";
      document.getElementById("resultInput").value = keyword;

      // Fetch search results from your WAMP server
      fetch("http://localhost/gout_et_avis/search.php?q=" + encodeURIComponent(keyword))
        .then(response => {
          if (!response.ok) throw new Error("Erreur lors de la recherche.");
          return response.json();
        })
        .then(data => {
          const resultsContainer = document.createElement("div");
          resultsContainer.classList.add("results-list");

          if (data.length === 0) {
            resultsContainer.innerHTML = "<p>Aucun restaurant trouvé.</p>";
          } else {
            data.forEach(r => {
              // Display restaurant information dynamically
              resultsContainer.innerHTML += `
                <div class="restaurant">
                  <h2>${r.nom}</h2>
                  <p><strong>Localisation :</strong> ${r.localisation}</p>
                  <p>${r.description}</p>
                  <p><strong>Catégorie :</strong> ${r.categorie}</p>
                  ${r.image ? `<img src="${r.image.split(',')[0]}" alt="Image de ${r.nom}" style="max-width:200px; border-radius:8px;">` : ''}
                </div>`;
            });
          }

          // Inject results into the results page
          const resultsPage = document.getElementById("results");
          // Clear previous results if any
          const oldResults = resultsPage.querySelector(".results-list");
          if (oldResults) oldResults.remove();
          resultsPage.appendChild(resultsContainer);
      
        
        });

    }, 600);
  }
});

function returnToSection(sectionId) {
  const resultsPage = document.getElementById("results");
  resultsPage.classList.add("slide-down");

  setTimeout(() => {
    resultsPage.style.display = "none";
    resultsPage.classList.remove("slide-down");

    const mainBackground = document.getElementById("mainBackground");
    mainBackground.style.display = "block";

    document.querySelectorAll(".content").forEach((el) => {
      el.style.display = "none";
    });

    document.getElementById(sectionId).style.display = "block";

    const links = mainBackground.querySelectorAll(".navbar a");
    links.forEach((link) => {
      link.classList.remove("active");
      if (link.textContent.toLowerCase() === sectionId) {
        link.classList.add("active");
      }
    });
  }, 600);
}

function showRestaurantPage(id) {
  window.location.href = "newpagerest.php?id=" + id;
}

 // Le délai de réinitialisation est de 1200ms, soit plus long que l'animation


/*function showContent(section) {
  document.querySelectorAll(".content").forEach((el) => {
    el.style.display = "none";
  });
  document.getElementById(section).style.display = "block";
  const links = document.querySelectorAll(".navbar a");
  links.forEach((link) => link.classList.remove("active"));
  event.target.classList.add("active");
}


function returnToSection(sectionId) {
  const resultsPage = document.getElementById("results");
  resultsPage.classList.add("slide-down");

  setTimeout(() => {
    resultsPage.style.display = "none";
    resultsPage.classList.remove("slide-down");

    const mainBackground = document.getElementById("mainBackground");
    mainBackground.style.display = "block";

    document.querySelectorAll(".content").forEach((el) => {
      el.style.display = "none";
    });

    document.getElementById(sectionId).style.display = "block";

    const links = mainBackground.querySelectorAll(".navbar a");
    links.forEach((link) => {
      link.classList.remove("active");
      if (link.textContent.toLowerCase() === sectionId) {
        link.classList.add("active");
      }
    });
  }, 600);
}


function showRecommendations() {
  const background = document.getElementById("mainBackground");
  background.classList.add("slide-up");

  setTimeout(() => {
    background.style.display = "none";
    background.classList.remove("slide-up");
    const results = document.getElementById("results");
    results.style.display = "block";
    document.querySelector(".results-text").style.display = "none";
  }, 600);
}
document.addEventListener("DOMContentLoaded", function () {
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.has("query")) {
const background = document.getElementById("mainBackground");
background.classList.add("slide-up");

setTimeout(() => {
    background.style.display = "none";
    background.classList.remove("slide-up");
    document.getElementById("results").style.display = "block";
    document.getElementById("resultInput").value = urlParams.get("query");
}, 600); // attendre que le slide-up s'affiche
}

});*/
