<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>AutoBird Booking Demo</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f5f5f5;
    }

    .hero {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    h1 {
      font-size: 36px;
      font-weight: bold;
      margin-bottom: 30px;
      text-align: center;
    }

    .form-box {
      background: #fff;
      padding: 30px;
      border-radius: 16px;
      max-width: 500px;
      width: 100%;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .booking-row {
      display: flex;
      align-items: flex-start;
      gap: 10px;
    }

    .icon-column {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-top: 8px;
    }

    .circle-dot, .square-dot {
      width: 10px;
      height: 10px;
      background: black;
    }

    .circle-dot {
      border-radius: 50%;
      margin-bottom: 6px;
    }

    .square-dot {
      margin-top: 6px;
    }

    .icon-line {
      width: 2px;
      height: 40px;
      background: black;
    }

    .input-column {
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    .form-group {
      display: flex;
      align-items: center;
      background: #f0f0f0;
      padding: 12px 16px;
      border-radius: 10px;
      position: relative;
    }

    .form-group input {
      border: none;
      outline: none;
      background: transparent;
      font-size: 16px;
      width: 100%;
    }

    .arrow {
      font-size: 18px;
      color: #000;
      margin-left: 10px;
    }

    .btn-continue {
      margin-top: 20px;
      background: black;
      color: white;
      padding: 14px;
      border: none;
      width: 100%;
      border-radius: 10px;
      font-size: 16px;
      cursor: pointer;
    }

    .btn-continue:hover {
      background: #333;
    }

    .login-prompt {
      margin-top: 15px;
      font-size: 14px;
      text-align: center;
    }

    .login-prompt a {
      color: #000;
      text-decoration: underline;
    }

    .autocomplete-suggestions {
      position: absolute;
      background: #fff;
      border: 1px solid #ccc;
      z-index: 9999;
      max-height: 150px;
      overflow-y: auto;
      width: 100%;
      top: 100%;
      left: 0;
    }

    .autocomplete-suggestion {
      padding: 10px;
      cursor: pointer;
    }

    .autocomplete-suggestion:hover {
      background: #f0f0f0;
    }
  </style>
</head>
<body>

<div class="hero">
  <h1>Go anywhere with AutoBird</h1>

  <div class="form-box">
    <form id="demoBookingForm">

      <div class="booking-row">
        <!-- Icon stack aligned -->
        <div class="icon-column">
          <div class="circle-dot"></div>
          <div class="icon-line"></div>
          <div class="square-dot"></div>
        </div>

        <!-- Input fields -->
        <div class="input-column">
          <div class="form-group">
            <input type="text" id="pickup" placeholder="Pickup location" required>
            <span class="arrow">&#10148;</span>
          </div>
          <div class="form-group">
            <input type="text" id="dropoff" placeholder="Dropoff location" required>
          </div>
        </div>
      </div>

      <button type="submit" class="btn-continue">Continue</button>
    </form>

    <div class="login-prompt">
      Already have an account? <a href="userlogin.php">Login</a>
    </div>
  </div>
</div>

<!-- Autocomplete JS -->
<script>
function setupAutocomplete(inputId) {
  const input = document.getElementById(inputId);
  const suggestionBox = document.createElement('div');
  suggestionBox.classList.add('autocomplete-suggestions');
  input.parentNode.appendChild(suggestionBox);

  input.addEventListener('input', function () {
    const query = input.value;
    if (query.length < 3) {
      suggestionBox.innerHTML = '';
      return;
    }

    fetch(`https://photon.komoot.io/api/?q=${encodeURIComponent(query)}&limit=5`)
      .then(res => res.json())
      .then(data => {
        suggestionBox.innerHTML = '';
        data.features.forEach(feature => {
          const suggestion = document.createElement('div');
          suggestion.classList.add('autocomplete-suggestion');
          suggestion.textContent = feature.properties.name + ', ' + 
            (feature.properties.city || '') + ', ' + 
            (feature.properties.state || '') + ', ' + 
            (feature.properties.country || '');
          suggestion.addEventListener('click', () => {
            input.value = suggestion.textContent;
            suggestionBox.innerHTML = '';
          });
          suggestionBox.appendChild(suggestion);
        });
      });
  });

  document.addEventListener('click', function (e) {
    if (!suggestionBox.contains(e.target) && e.target !== input) {
      suggestionBox.innerHTML = '';
    }
  });
}

setupAutocomplete('pickup');
setupAutocomplete('dropoff');

document.getElementById("demoBookingForm").addEventListener("submit", function(e) {
  e.preventDefault();
  window.location.href = "userlogin.php"; // demo redirect
});
</script>

</body>
</html>
