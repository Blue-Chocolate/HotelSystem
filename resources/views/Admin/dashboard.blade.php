<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Hotel System Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    :root {
      --primary-brown: #8B4513;
      --light-bg: #f9f6f2;
      --light-text: #333;
      --dark-bg: #2e2b29;
      --dark-text: #f5f5f5;
      --card-bg-light: #fff;
      --card-bg-dark: #3b3531;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      transition: background-color 0.3s, color 0.3s;
    }

    .light-mode {
      background-color: var(--light-bg);
      color: var(--light-text);
    }

    .dark-mode {
      background-color: var(--dark-bg);
      color: var(--dark-text);
    }

    header {
      background-color: var(--primary-brown);
      color: white;
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .dashboard {
      padding: 2rem;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 1.5rem;
    }

    .card {
      background-color: var(--card-bg-light);
      padding: 1.5rem;
      border-radius: 12px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      transition: background-color 0.3s;
    }
    .card-link {
  text-decoration: none;
  color: inherit;
}
.card-link:hover .card {
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
  transform: translateY(-2px);
}

    .dark-mode .card {
      background-color: var(--card-bg-dark);
    }

    .toggle-btn {
      background-color: white;
      border: none;
      color: var(--primary-brown);
      padding: 0.5rem 1rem;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
    }

    .toggle-btn:hover {
      background-color: #f2e6dd;
    }

    h2 {
      margin: 0 0 1rem 0;
    }
  </style>
</head>
<body class="light-mode">
  <header>
    <h1>Hotel Dashboard</h1>
    <button class="toggle-btn" onclick="toggleMode()">Switch Theme</button>
  </header>

  <main class="dashboard">

<a href="{{ route('admin.reserve.index') }}" class="card-link">
  <div class="card">
    <h2>Reservations</h2>
    <p>{{ $reservationCount }} total bookings</p>
  </div>
</a>

<a href="{{ route('admin.guests.index') }}" class="card-link">
  <div class="card">
    <h2>Guests</h2>
    <p>{{ $guestCount }} total guests</p>
  </div>
</a>

<a href="{{ route('admin.rooms.index') }}" class="card-link">
  <div class="card">
    <h2>Rooms Available</h2>
    <p>{{ $availableRooms }} rooms available</p>
  </div>
</a>

<a href="{{ route('admin.revenue.index') }}" class="card-link">
  <div class="card">
    <h2>Revenue</h2>
    <p>${{ number_format($revenue, 2) }} revenue</p>
  </div>
</a>

</main>

  <div style="grid-column: span 2;">
  <a href="{{ route('admin.reserve.create') }}" class="toggle-btn" style="display: inline-block; margin-top: 2rem;">
    + Make Reservation for Guest
  </a>
</div>

  <script>
    function toggleMode() {
      const body = document.body;
      body.classList.toggle('dark-mode');
      body.classList.toggle('light-mode');
    }
  </script>
</body>
</html>
