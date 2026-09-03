<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>MarketSmart - Super Admin Dashboard</title>

    <link rel="stylesheet" href="{{ asset ('smart.css') }}">

</head>

<body>

<div class="dashboard-container">
<!-- Sidebar -->


        <!-- Header -->
        @include('layout.business.header')
<div class="split">
         <!-- Main Section -->
         @include('layout.superadmin.supadminsidebar')
    <main class="main-content"></main>
    <div class="main-content">
    @include('layout.superadmin.supadminheader')


        <!-- Dashboard Content -->
        <section class="dashboard-content">

            <div class="welcome-section">

                <div>
                    <h1>Welcome, Super Admin!</h1>

                    <p>
                        Here's what's happening with MarketSmart today.
                    </p>
                </div>

                <div class="date-box">
                    📅 &nbsp; 24 July 2025, Thursday
                </div>

            </div>
        </div>


            <!-- Statistics Cards -->
            <div class="stats-grid">

                <div class="stat-card">

                    <div class="stat-icon green">
                        🏪
                    </div>

                    <div>
                        <p>Total Supermarkets</p>

                        <h2>128</h2>

                        <span class="growth">
                            ↗ 12 this month
                        </span>
                    </div>

                </div>


                <div class="stat-card">

                    <div class="stat-icon blue">
                        👥
                    </div>

                    <div>
                        <p>Total Users</p>

                        <h2>364</h2>

                        <span class="growth">
                            ↗ 28 this month
                        </span>
                    </div>

                </div>


                <div class="stat-card">

                    <div class="stat-icon purple">
                        🛒
                    </div>

                    <div>
                        <p>Total Transactions</p>

                        <h2>8,742</h2>

                        <span class="growth">
                            ↗ 18.7% this month
                        </span>
                    </div>

                </div>


                <div class="stat-card">

                    <div class="stat-icon orange">
                        $
                    </div>

                    <div>
                        <p>Total Revenue</p>

                        <h2>$24,560.00</h2>

                        <span class="growth">
                            ↗ 22.5% this month
                        </span>
                    </div>

                </div>






        <!-- Footer -->
        @include('layout.business.footer')

    </main>

</div>

</body>

</html>
