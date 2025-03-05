
     document.addEventListener("DOMContentLoaded", function() {
      const searchInput = document.getElementById("search");
      const searchForm = document.getElementById("searchForm");
      const suggestionsContainer = document.getElementById("suggestions");
      const searchResults = document.getElementById("searchResults");


      searchInput.addEventListener("keyup", function(event) {
        let query = searchInput.value.trim();

        if (query.length === 0) {
          suggestionsContainer.innerHTML = "";
          return;
        }

        fetch("search_suggestions.php?query=" + encodeURIComponent(query))
          .then(response => response.json())
          .then(data => {
            let suggestionsHtml = "";
            if (data.length > 0) {
              suggestionsHtml = data.map(item => `
                        <div class='suggestion-item' onclick='selectSuggestion("${item.name}")'>
                            <img src="${item.image_url}" alt="${item.name}" width="50">
                            ${item.name}
                        </div>
                    `).join("");
            } else {
              suggestionsHtml = "<p class='suggestion-item'>Không tìm thấy kết quả</p>";
            }
            suggestionsContainer.innerHTML = suggestionsHtml;
          })
          .catch(error => console.error("Lỗi gợi ý:", error));
      });


      window.selectSuggestion = function(name) {
        searchInput.value = name;
        suggestionsContainer.innerHTML = "";
        searchMedicine();
      };


      searchInput.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
          event.preventDefault();
          searchMedicine();
        }
      });


      searchForm.addEventListener("submit", function(event) {
        event.preventDefault();
        searchMedicine();
      });

      
      function searchMedicine() {
        let query = searchInput.value.trim();

        if (query.length === 0) {
          searchResults.innerHTML = "<p>⚠️ Vui lòng nhập từ khóa!</p>";
          return;
        }

        searchResults.innerHTML = "<p>🔍 Đang tìm kiếm...</p>"; 

        fetch("search_suggestions.php?query=" + encodeURIComponent(query))
          .then(response => response.json())
          .then(data => {
            searchResults.innerHTML = "";

            if (data.length > 0) {
              let productsHtml = "";
              data.forEach(item => {
                productsHtml += `
                            <div class="product-card">
                                <img src="${item.image_url}" alt="${item.name}" width="100">
                                <p><strong>${item.name}</strong></p>
                                <p>💰 Giá: ${item.price.toLocaleString()} VNĐ</p>
                                <a href="../product_detail/product-detail.php?id=${item.id}" class="btn btn-info">🔎 Xem chi tiết</a>
                            </div>
                        `;
              });
              searchResults.innerHTML = productsHtml;
            } else {
              searchResults.innerHTML = "<p>❌ Không tìm thấy sản phẩm nào.</p>";
            }
          })
          .catch(error => {
            console.error("Lỗi tìm kiếm:", error);
            searchResults.innerHTML = "<p>⚠️ Lỗi kết nối đến máy chủ!</p>";
          });
      }
    });

