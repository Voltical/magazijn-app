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

  <!-- Winkelmand knop rechtsboven -->
  <button id="cartToggle" class="cart-toggle">🛒 Winkelmand</button>

  <!-- Winkelmand container -->
  <div id="cartContainer" class="cart-container">
    <h3>🛒 Winkelmand</h3>
    <div id="cartList" class="cart-list"></div>
    <p id="cartTotal"><strong>Totaal:</strong> €0.00</p>
    <button id="checkoutBtn">✅ Bestelling plaatsen</button>
  </div>

  <!-- Hoofdinhoud -->
  <div class="content" style="display:flex; gap:30px;">

    <!-- Formulier links -->
    <form id="itemForm" style="flex:1;">
      <h1>📦 Product toevoegen</h1>
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
    </form>

    <!-- Live preview rechts -->
    <div class="preview" style="flex:1; border:1px solid #ccc; border-radius:8px; padding:15px;">
      <h2>📌 Preview</h2>
      <div id="previewContent">
        <p>Vul het formulier in om het product te zien.</p>
      </div>
      <button id="addToCartPreviewBtn" style="margin-top:10px; padding:8px; border:none; border-radius:6px; background-color:#2e8b57; color:white; cursor:pointer;">🛒 Toevoegen aan winkelmand</button>
    </div>

  </div>

<script>
const itemName = document.getElementById('itemName');
const itemDescription = document.getElementById('itemDescription');
const itemAmount = document.getElementById('itemAmount');
const itemPrice = document.getElementById('itemPrice');
const itemImage = document.getElementById('itemImage');

const previewContent = document.getElementById('previewContent');
const addToCartPreviewBtn = document.getElementById('addToCartPreviewBtn');

const cartToggle = document.getElementById('cartToggle');
const cartContainer = document.getElementById('cartContainer');
const cartList = document.getElementById('cartList');
const cartTotal = document.getElementById('cartTotal');
const checkoutBtn = document.getElementById('checkoutBtn');

let cart = JSON.parse(localStorage.getItem('winkelmand')) || [];
let currentPreviewItem = null;

// 🔄 Update preview live
function updatePreview() {
  if(!itemName.value && !itemDescription.value && !itemAmount.value && !itemPrice.value && !itemImage.files[0]){
    previewContent.innerHTML = '<p>Vul het formulier in om het product te zien.</p>';
    currentPreviewItem = null;
    return;
  }

  if(itemImage.files[0]){
    const reader = new FileReader();
    reader.onload = function(event){
      previewContent.innerHTML = `
        <img src="${event.target.result}" style="width:100px;height:100px;object-fit:cover;border-radius:5px;">
        <h3>${itemName.value || ''}</h3>
        <p>${itemDescription.value || ''}</p>
        <p>Hoeveelheid: ${itemAmount.value || 0}</p>
        <p>Prijs: €${parseFloat(itemPrice.value||0).toFixed(2)}</p>
      `;
      currentPreviewItem = {
        name: itemName.value,
        description: itemDescription.value,
        amount: parseInt(itemAmount.value||1),
        price: parseFloat(itemPrice.value||0),
        image: event.target.result
      };
    };
    reader.readAsDataURL(itemImage.files[0]);
  } else {
    previewContent.innerHTML = `
      <h3>${itemName.value || ''}</h3>
      <p>${itemDescription.value || ''}</p>
      <p>Hoeveelheid: ${itemAmount.value || 0}</p>
      <p>Prijs: €${parseFloat(itemPrice.value||0).toFixed(2)}</p>
    `;
    currentPreviewItem = {
      name: itemName.value,
      description: itemDescription.value,
      amount: parseInt(itemAmount.value||1),
      price: parseFloat(itemPrice.value||0),
      image: null
    };
  }
}

// Event listeners voor live update
[itemName, itemDescription, itemAmount, itemPrice, itemImage].forEach(el=>{
  el.addEventListener('input', updatePreview);
});

// ➕ Voeg preview item toe aan winkelmand
addToCartPreviewBtn.addEventListener('click', () => {
  if(!currentPreviewItem || !currentPreviewItem.name) return alert('Vul het product volledig in!');
  const existing = cart.find(p => p.name === currentPreviewItem.name);
  if(existing){
    existing.amount += currentPreviewItem.amount;
  } else {
    cart.push(currentPreviewItem);
  }
  localStorage.setItem('winkelmand', JSON.stringify(cart));
  renderCart();
  document.getElementById('itemForm').reset();
  updatePreview();
});

// ❌ Verwijderen uit winkelmand
cartList.addEventListener('click', e => {
  if(e.target.classList.contains('remove-cart-btn')){
    const index = e.target.dataset.index;
    cart.splice(index,1);
    renderCart();
  }
});

// Winkelmand toggle
cartToggle.addEventListener('click', ()=> cartContainer.classList.toggle('visible'));

// Bestelling plaatsen
checkoutBtn.addEventListener('click', ()=>{
  alert('Bestelling geplaatst!');
  cart = [];
  renderCart();
});

// Render winkelmand
function renderCart(){
  cartList.innerHTML = '';
  let total = 0;
  cart.forEach((item,index)=>{
    total += item.amount * item.price;
    const div = document.createElement('div');
    div.classList.add('cart-item');
    div.innerHTML = `
      <img src="${item.image || ''}" alt="${item.name}" style="width:50px;height:50px;object-fit:cover;border-radius:5px;">
      <div style="flex:1; margin-left:10px;">
        <strong>${item.name}</strong> (${item.amount}x) - €${(item.amount*item.price).toFixed(2)}
        <p>${item.description}</p>
      </div>
      <button class="remove-cart-btn" data-index="${index}">❌</button>
    `;
    cartList.appendChild(div);
  });
  cartTotal.textContent = `💰 Totaal: €${total.toFixed(2)}`;
  localStorage.setItem('winkelmand', JSON.stringify(cart));
}

renderCart();
updatePreview();
</script>
</body>
</html>
