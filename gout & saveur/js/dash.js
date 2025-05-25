document.addEventListener("DOMContentLoaded", () => {
  // Navigation functionality
  const navLinks = document.querySelectorAll(".nav-links li")
  const sections = document.querySelectorAll(".section")

  navLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault()

      // Remove active class from all links and sections
      navLinks.forEach((item) => item.classList.remove("active"))
      sections.forEach((section) => section.classList.remove("active"))

      // Add active class to clicked link
      this.classList.add("active")

      // Show corresponding section
      const targetId = this.getAttribute("data-target")
      document.getElementById(targetId).classList.add("active")
    })
  })

  // Search functionality
  const searchInputs = document.querySelectorAll('input[type="text"][id$="-search"]')

  // Modifiez la partie de recherche comme ceci :
  searchInputs.forEach((input) => {
      input.addEventListener("keyup", function () {
          const searchTerm = this.value.toLowerCase();
          const tableId = this.id.split("-")[0];
          const table = document.getElementById(tableId);

          if (!table) return; // Ajoutez cette vérification

          const tableRows = table.querySelectorAll("tbody tr");

          tableRows.forEach((row) => {
            const text = row.textContent.toLowerCase()
            if (text.includes(searchTerm)) {
              row.style.display = ""
            } else {
              row.style.display = "none"
            }
          })
      })
  });

  // Form submission
  const restaurantForm = document.getElementById("restaurant-form")

  restaurantForm.addEventListener("submit", function (e) {
    e.preventDefault();

    const name = document.getElementById("restaurant-name").value;
    const category = document.getElementById("restaurant-category").value;
    const location = document.getElementById("restaurant-location").value;
    const description = document.getElementById("restaurant-description").value;
    const imageUrl = document.getElementById("restaurant-image").value;

    if (!name || !category || !location || !description) {
        alert("Veuillez remplir tous les champs obligatoires.");
        return;
    }

    const formData = new FormData();
    formData.append('nom', name);
    formData.append('categorie', category);
    formData.append('localisation', location);
    formData.append('description', description);
    formData.append('image_url', imageUrl);

    fetch('restaurant-add.php', {
      method: 'POST',
      body: formData
  })
  .then(response => {
      if (!response.ok) {
          throw new Error("Erreur lors de l'ajout du restaurant.");
      }
      return response.json();
  })
  .then(result => {
      if (result.success) {
          alert(`Restaurant "${result.data.nom}" ajouté avec succès!`);
          console.log("Données ajoutées :", result.data);  // ✅ Logged here
          restaurantForm.reset();

          // Rediriger ou mettre à jour l’interface
          navLinks.forEach((item) => item.classList.remove("active"));
          sections.forEach((section) => section.classList.remove("active"));
          document.querySelector('[data-target="restaurants"]').classList.add("active");
          document.getElementById("restaurants").classList.add("active");
      } else {
          alert("Erreur : " + result.error);
      }
  })
  .catch(error => {
      alert("Une erreur est survenue : " + error.message);
  });

});


  // Delete button functionality is now handled in dash.php for specific elements
  // (users, restaurants, and avis each have their own handlers)

  // File input functionality
  /*
  const fileInput = document.getElementById("restaurant-image")
  const fileLabel = document.querySelector(".file-label span")

  fileInput.addEventListener("change", function () {
    if (this.files.length > 0) {
      fileLabel.textContent = this.files[0].name
    } else {
      fileLabel.textContent = "Choisir un fichier"
    }
  })
*/
  // Pagination functionality (simplified for demo)
  const paginationButtons = document.querySelectorAll(".btn-page")

  paginationButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const paginationContainer = this.closest(".pagination")
      const activeButton = paginationContainer.querySelector(".btn-page.active")

      if (this !== activeButton && !this.classList.contains("active")) {
        activeButton.classList.remove("active")
        this.classList.add("active")

        // In a real application, you would fetch data for the selected page
        // For this example, we'll just scroll to the top of the table
        const tableContainer = paginationContainer.previousElementSibling
        tableContainer.scrollIntoView({ behavior: "smooth" })
      }
    })
  })

  // Advanced Filters Functionality
  const filterToggles = document.querySelectorAll(".btn-filter")

  filterToggles.forEach((toggle) => {
    toggle.addEventListener("click", function () {
      const filterId = this.id.split("-filter-")[0]
      const filterContainer = document.getElementById(`${filterId}-advanced-filters`)

      filterContainer.classList.toggle("active")

      // Update button text
      if (filterContainer.classList.contains("active")) {
        this.innerHTML = '<i class="fas fa-times"></i> Masquer les filtres'
      } else {
        this.innerHTML = '<i class="fas fa-filter"></i> Filtres avancés'
      }
    })
  })

  // Range slider for restaurant ratings
  const ratingMin = document.getElementById("rating-min")
  const ratingMax = document.getElementById("rating-max")
  const ratingMinValue = document.getElementById("rating-min-value")
  const ratingMaxValue = document.getElementById("rating-max-value")

  if (ratingMin && ratingMax) {
    // Update min value display
    ratingMin.addEventListener("input", function () {
      ratingMinValue.textContent = this.value

      // Ensure min doesn't exceed max
      if (Number.parseFloat(this.value) > Number.parseFloat(ratingMax.value)) {
        ratingMax.value = this.value
        ratingMaxValue.textContent = this.value
      }
    })

    // Update max value display
    ratingMax.addEventListener("input", function () {
      ratingMaxValue.textContent = this.value

      // Ensure max isn't less than min
      if (Number.parseFloat(this.value) < Number.parseFloat(ratingMin.value)) {
        ratingMin.value = this.value
        ratingMinValue.textContent = this.value
      }
    })
  }

  // Apply filters for users
  const userFilterApply = document.getElementById("user-filter-apply")
  if (userFilterApply) {
    userFilterApply.addEventListener("click", () => {
      const statusCheckboxes = document.querySelectorAll("#user-advanced-filters .filter-checkbox input:checked")
      const dateFrom = document.getElementById("user-date-from").value
      const dateTo = document.getElementById("user-date-to").value

      const statuses = Array.from(statusCheckboxes).map((cb) => cb.value)
      const userRows = document.querySelectorAll("#users tbody tr")

      userRows.forEach((row) => {
        let display = true

        // Check status
        const statusCell = row.querySelector("td:nth-child(5)")
        const statusText = statusCell.textContent.toLowerCase()

        if (!statuses.some((s) => statusText.includes(s))) {
          display = false
        }

        // Check date range
        if (dateFrom || dateTo) {
          const dateCell = row.querySelector("td:nth-child(4)").textContent
          const dateParts = dateCell.split("/")
          const rowDate = new Date(dateParts[2], dateParts[1] - 1, dateParts[0])

          if (dateFrom) {
            const fromDate = new Date(dateFrom)
            if (rowDate < fromDate) {
              display = false
            }
          }

          if (dateTo) {
            const toDate = new Date(dateTo)
            if (rowDate > toDate) {
              display = false
            }
          }
        }

        row.style.display = display ? "" : "none"
      })
    })
  }

  // Apply filters for restaurants
  const restaurantFilterApply = document.getElementById("restaurant-filter-apply")
  if (restaurantFilterApply) {
    restaurantFilterApply.addEventListener("click", () => {
      const categoryCheckboxes = document.querySelectorAll(
        "#restaurant-advanced-filters .filter-checkbox input:checked",
      )
      const minRating = Number.parseFloat(document.getElementById("rating-min").value)
      const maxRating = Number.parseFloat(document.getElementById("rating-max").value)
      const cityFilter = document.getElementById("restaurant-city-filter").value

      const categories = Array.from(categoryCheckboxes).map((cb) => cb.value)
      const restaurantRows = document.querySelectorAll("#restaurants tbody tr")

      restaurantRows.forEach((row) => {
        let display = true

        // Check category
        const categoryCell = row.querySelector("td:nth-child(3)").textContent.toLowerCase()
        let categoryMatch = false

        categories.forEach((category) => {
          if (categoryCell.toLowerCase().includes(category.toLowerCase())) {
            categoryMatch = true
          }
        })

        if (categories.length > 0 && !categoryMatch) {
          display = false
        }

        // Check rating
        const ratingText = row.querySelector(".rating span").textContent
        const rating = Number.parseFloat(ratingText)

        if (rating < minRating || rating > maxRating) {
          display = false
        }

        // Check city
        if (cityFilter) {
          const addressCell = row.querySelector("td:nth-child(4)").textContent
          if (!addressCell.includes(cityFilter)) {
            display = false
          }
        }

        row.style.display = display ? "" : "none"
      })
    })
  }

  // Apply filters for reviews
  const reviewFilterApply = document.getElementById("review-filter-apply")
  if (reviewFilterApply) {
    reviewFilterApply.addEventListener("click", () => {
      const ratingCheckboxes = document.querySelectorAll("#review-advanced-filters .star-option input:checked")
      const dateFrom = document.getElementById("review-date-from").value
      const dateTo = document.getElementById("review-date-to").value
      const restaurantFilter = document.getElementById("review-restaurant-filter").value

      const ratings = Array.from(ratingCheckboxes).map((cb) => Number.parseInt(cb.value))
      const reviewRows = document.querySelectorAll("#reviews tbody tr")

      reviewRows.forEach((row) => {
        let display = true

        // Check rating
        const ratingText = row.querySelector(".rating span").textContent
        const rating = Math.round(Number.parseFloat(ratingText))

        if (!ratings.includes(rating)) {
          display = false
        }

        // Check date range
        if (dateFrom || dateTo) {
          const dateCell = row.querySelector("td:nth-child(6)").textContent
          const dateParts = dateCell.split("/")
          const rowDate = new Date(dateParts[2], dateParts[1] - 1, dateParts[0])

          if (dateFrom) {
            const fromDate = new Date(dateFrom)
            if (rowDate < fromDate) {
              display = false
            }
          }

          if (dateTo) {
            const toDate = new Date(dateTo)
            if (rowDate > toDate) {
              display = false
            }
          }
        }

        // Check restaurant
        if (restaurantFilter) {
          const restaurantCell = row.querySelector("td:nth-child(3)").textContent
          if (restaurantCell !== restaurantFilter) {
            display = false
          }
        }

        row.style.display = display ? "" : "none"
      })
    })
  }

  // Reset filters
  const resetButtons = document.querySelectorAll('[id$="-filter-reset"]')
  resetButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const filterId = this.id.split("-filter-")[0]

      // Reset checkboxes
      const checkboxes = document.querySelectorAll(`#${filterId}-advanced-filters input[type="checkbox"]`)
      checkboxes.forEach((cb) => {
        cb.checked = true
      })

      // Reset date inputs
      const dateInputs = document.querySelectorAll(`#${filterId}-advanced-filters input[type="date"]`)
      dateInputs.forEach((input) => {
        input.value = ""
      })

      // Reset selects
      const selects = document.querySelectorAll(`#${filterId}-advanced-filters select`)
      selects.forEach((select) => {
        select.value = ""
      })

      // Reset range sliders
      if (filterId === "restaurant") {
        document.getElementById("rating-min").value = 0
        document.getElementById("rating-max").value = 5
        document.getElementById("rating-min-value").textContent = "0"
        document.getElementById("rating-max-value").textContent = "5"
      }

      // Show all rows
      const rows = document.querySelectorAll(`#${filterId}s tbody tr`)
      rows.forEach((row) => {
        row.style.display = ""
      })
    })
  })
})

// La gestion de la modification de restaurant est maintenant dans dash.php
