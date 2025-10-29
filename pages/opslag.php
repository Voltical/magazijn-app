<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/css/magazijn.css">
  <title>Opslag</title>
</head>
<body>

  <!-- Sidebar -->
  <div class="left-container">
    <div class="sidebar-buttons"> 
      <a href="dash_board.php" class="sidebar-btn">
        <img src="../assets/images/huis.png" class="icon" alt="huis icoon">
        Dashboard
      </a>

      <a href="placeholder.php" class="sidebar-btn">
        <img src="../assets/images/monitor.png" class="icon" alt="monitor icoon">
        Placeholder
      </a>

      <a href="opslag.php" class="sidebar-btn active">
        <img src="../assets/images/doos.png" class="icon" alt="doos icoon">
        Opslag
      </a>

      <a href="grafiek.php" class="sidebar-btn">
        <img src="../assets/images/grafiek.png" class="icon" alt="grafiek icoon">
        Grafiek
      </a>
    </div>
  </div>

  <!-- Hoofdinhoud -->
  <div class="content">
    <h1>📦 Magazijnbeheer</h1>

    <form id="itemForm">
      <label>Naam van item:</label>
      <input type="text" id="itemName" placeholder="Bijv. Schroevendraaier" required>

      <label>Beschrijving:</label>
      <textarea id="itemDescription" placeholder="Korte beschrijving..." required></textarea>

      <label>Hoeveelheid:</label>
      <input type="number" id="itemAmount" placeholder="Bijv. 10" min="1" required>

      <label>Prijs per stuk (€):</label>
      <input type="number" id="itemPrice" placeholder="Bijv. 4.99" step="0.01" min="0" required>

      <label>Foto uploaden:</label>
      <input type="file" id="itemImage" accept="image/*" required>

      <button type="submit">Item toevoegen</button>
    </form>

    <h2>🗂️ Overzicht van items</h2>
    <div id="itemList" class="item-list"></div>

    <h2>🛒 Winkelmand</h2>
    <div id="cartList" class="cart-list"></div>
    <p id="cartTotal"><strong>Totaal:</strong> €0.00</p>
  </div>

  <script>
    const form = document.getElementById('itemForm');
    const itemList = document.getElementById('itemList');
    const cartList = document.getElementById('cartList');
    const cartTotal = document.getElementById('cartTotal');

    let items = JSON.parse(localStorage.getItem('magazijnItems')) || [];
    let cart = JSON.parse(localStorage.getItem('winkelmand')) || [];

    // 🔄 Herladen van lijst
    function renderItems() {
      itemList.innerHTML = '';
      items.forEach((item, index) => {
        const card = document.createElement('div');
        card.classList.add('item-card');
        card.innerHTML = `
          <img src="${item.image}" alt="${item.name}">
          <div class="item-info">
            <h3>${item.name}</h3>
            <p>${item.description}</p>
            <p><strong>Hoeveelheid:</strong> ${item.amount}</p>
            <p><strong>Prijs:</strong> €${parseFloat(item.price).toFixed(2)}</p>
          </div>
          <div class="actions">
            <button class="add-cart-btn" data-index="${index}">🛒 Toevoegen</button>
            <button class="delete-btn" data-index="${index}">❌</button>
          </div>
        `;
        itemList.appendChild(card);
      });
    }

    // 🔄 Winkelmand tonen
    function renderCart() {
      cartList.innerHTML = '';
      let total = 0;
      cart.forEach((item, index) => {
        total += item.amount * item.price;
        const div = document.createElement('div');
        div.classList.add('cart-item');
        div.innerHTML = `
          <span>${item.name} (${item.amount}x) - €${(item.amount * item.price).toFixed(2)}</span>
          <button class="remove-cart-btn" data-index="${index}">❌</button>
        `;
        cartList.appendChild(div);
      });
      cartTotal.textContent = `💰 Totaal: €${total.toFixed(2)}`;
      localStorage.setItem('winkelmand', JSON.stringify(cart));
    }

    // ➕ Item toevoegen aan opslag
    form.addEventListener('submit', (e) => {
      e.preventDefault();

      const name = document.getElementById('itemName').value;
      const description = document.getElementById('itemDescription').value;
      const amount = document.getElementById('itemAmount').value;
      const price = document.getElementById('itemPrice').value;
      const imageFile = document.getElementById('itemImage').files[0];

      if (!imageFile) return alert('Upload een foto!');

      const reader = new FileReader();
      reader.onload = function(event) {
        const newItem = { name, description, amount, price, image: event.target.result };
        items.push(newItem);
        localStorage.setItem('magazijnItems', JSON.stringify(items));
        renderItems();
        form.reset();
      };

      reader.readAsDataURL(imageFile);
    });

    // ❌ Verwijderen uit opslag
    itemList.addEventListener('click', (e) => {
      if (e.target.classList.contains('delete-btn')) {
        const index = e.target.dataset.index;
        items.splice(index, 1);
        localStorage.setItem('magazijnItems', JSON.stringify(items));
        renderItems();
      }

      // 🛒 Toevoegen aan winkelmand
      if (e.target.classList.contains('add-cart-btn')) {
        const index = e.target.dataset.index;
        const product = items[index];
        const existing = cart.find(p => p.name === product.name);
        if (existing) {
          existing.amount = parseInt(existing.amount) + parseInt(product.amount);
        } else {
          cart.push({ ...product });
        }
        localStorage.setItem('winkelmand', JSON.stringify(cart));
        renderCart();
      }
    });

    // ❌ Item verwijderen uit winkelmand
    cartList.addEventListener('click', (e) => {
      if (e.target.classList.contains('remove-cart-btn')) {
        const index = e.target.dataset.index;
        cart.splice(index, 1);
        localStorage.setItem('winkelmand', JSON.stringify(cart));
        renderCart();
      }
    });

    // Eerste keer laden
    renderItems();
    renderCart();
  </script>

</body>
</html>
