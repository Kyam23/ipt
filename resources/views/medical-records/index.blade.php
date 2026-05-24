<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Records Dashboard - Student Medical Record System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #1e40af;
            --primary-light: #3b82f6;
            --secondary: #06b6d4;
            --accent: #c084fc;
            --success: #10b981;
            --danger: #ef4444;
            --bg-light: #f8fafc;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --border-color: #e2e8f0;
        }

        html, body {
            height: 100%;
            scroll-behavior: smooth;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* Navigation */
        .navbar {
            background: white;
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 2rem;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 800;
            font-size: 20px;
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
        }

        .navbar-brand i {
            font-size: 28px;
        }

        .navbar-menu {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .navbar-link {
            color: var(--text-light);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
            position: relative;
        }

        .navbar-link:hover {
            color: var(--primary-light);
        }

        .navbar-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-light), var(--secondary));
            transition: width 0.3s ease;
        }

        .navbar-link:hover::after {
            width: 100%;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .user-name {
            font-weight: 600;
            font-size: 14px;
            color: var(--text-dark);
        }

        .user-email {
            font-size: 12px;
            color: var(--text-light);
        }

        .logout-btn {
            background: linear-gradient(135deg, var(--danger) 0%, #dc2626 100%);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            font-size: 14px;
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(239, 68, 68, 0.3);
        }

        /* Main Container */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Header Section */
        .header {
            margin-bottom: 3rem;
            animation: fadeInDown 0.6s ease-out;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header h1 {
            font-size: 32px;
            margin-bottom: 8px;
            color: var(--text-dark);
        }

        .header p {
            color: var(--text-light);
            font-size: 16px;
        }

        /* Dashboard Grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .dashboard-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dashboard-card:nth-child(1) { animation-delay: 0.1s; }
        .dashboard-card:nth-child(2) { animation-delay: 0.2s; }
        .dashboard-card:nth-child(3) { animation-delay: 0.3s; }
        .dashboard-card:nth-child(4) { animation-delay: 0.4s; }

        .dashboard-card:hover {
            border-color: var(--primary-light);
            box-shadow: 0 12px 32px rgba(59, 130, 246, 0.1);
            transform: translateY(-4px);
        }

        .card-icon {
            width: 64px;
            height: 64px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin-bottom: 16px;
        }

        .card-icon.blue {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(6, 182, 212, 0.1) 100%);
            color: var(--primary-light);
        }

        .card-icon.cyan {
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.1) 0%, rgba(192, 132, 252, 0.1) 100%);
            color: var(--secondary);
        }

        .card-icon.purple {
            background: linear-gradient(135deg, rgba(192, 132, 252, 0.1) 0%, rgba(59, 130, 246, 0.1) 100%);
            color: var(--accent);
        }

        .card-icon.green {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(6, 182, 212, 0.1) 100%);
            color: var(--success);
        }

        .card-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--text-dark);
        }

        .card-value {
            font-size: 28px;
            font-weight: 800;
            color: var(--primary-light);
            margin-bottom: 4px;
        }

        .card-label {
            font-size: 14px;
            color: var(--text-light);
        }

        /* Table Section */
        .table-section {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            overflow: hidden;
            animation: fadeInUp 0.6s ease-out;
            animation-delay: 0.5s;
        }

        .table-header {
            padding: 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-header h2 {
            font-size: 20px;
            color: var(--text-dark);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--secondary) 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(59, 130, 246, 0.3);
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: var(--bg-light);
        }

        th {
            padding: 16px 24px;
            text-align: left;
            font-weight: 700;
            font-size: 14px;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 16px 24px;
            border-top: 1px solid var(--border-color);
            font-size: 14px;
            color: var(--text-dark);
        }

        tbody tr:hover {
            background-color: var(--bg-light);
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-active {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .status-pending {
            background-color: rgba(192, 132, 252, 0.1);
            color: var(--accent);
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 2rem;
            border-top: 1px solid var(--border-color);
            color: var(--text-light);
            font-size: 14px;
            margin-top: 3rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar-content {
                flex-direction: column;
                gap: 1rem;
            }

            .navbar-menu {
                flex-direction: column;
                width: 100%;
            }

            .container {
                padding: 1rem;
            }

            .header h1 {
                font-size: 24px;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .table-header {
                flex-direction: column;
                gap: 1rem;
            }

            table {
                font-size: 12px;
            }

            th, td {
                padding: 12px 16px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="navbar-content">
            <a href="{{ route('medical-records.index') }}" class="navbar-brand">
                <i class="fas fa-heartbeat"></i>
                MedRecord
            </a>

            <div class="navbar-menu">
                <a href="#" class="navbar-link">
                    <i class="fas fa-chart-line"></i>
                    Analytics
                </a>
                <a href="{{ route('medical-records.index') }}" class="navbar-link">
                    <i class="fas fa-file-medical"></i>
                    Records
                </a>
                <a href="#" class="navbar-link">
                    <i class="fas fa-cog"></i>
                    Settings
                </a>
            </div>

            <div class="user-menu">
                <div class="user-info">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <span class="user-email">{{ Auth::user()->email }}</span>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Welcome back, {{ Auth::user()->name }}! 👋</h1>
            <p>Your medical records dashboard is ready. Manage and view your health information securely.</p>
        </div>

        <!-- Dashboard Cards -->
        <div class="dashboard-grid">
            <div class="dashboard-card">
                <div class="card-icon blue">
                    <i class="fas fa-file-medical"></i>
                </div>
                <div class="card-title">Total Records</div>
                <div class="card-value">12</div>
                <div class="card-label">Medical records on file</div>
            </div>

            <div class="dashboard-card">
                <div class="card-icon cyan">
                    <i class="fas fa-stethoscope"></i>
                </div>
                <div class="card-title">Last Visit</div>
                <div class="card-value">May 15</div>
                <div class="card-label">Most recent checkup</div>
            </div>

            <div class="dashboard-card">
                <div class="card-icon purple">
                    <i class="fas fa-pill"></i>
                </div>
                <div class="card-title">Medications</div>
                <div class="card-value">3</div>
                <div class="card-label">Active prescriptions</div>
            </div>

            <div class="dashboard-card">
                <div class="card-icon green">
                    <i class="fas fa-heart-pulse"></i>
                </div>
                <div class="card-title">Health Status</div>
                <div class="card-value">Good</div>
                <div class="card-label">Overall wellness</div>
            </div>
        </div>

        <!-- Recent Records Table -->
        <div class="table-section">
            <div class="table-header">
                <h2>Recent Medical Records</h2>
                <a href="{{ route('medical-records.create') }}" class="btn-primary">
                    <i class="fas fa-plus"></i>
                    Add Record
                </a>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Provider</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>May 15, 2026</td>
                            <td>Regular Checkup</td>
                            <td>Dr. Smith</td>
                            <td><span class="status-badge status-active">Completed</span></td>
                            <td><a href="#" style="color: var(--primary-light); text-decoration: none; font-weight: 600;">View</a></td>
                        </tr>
                        <tr>
                            <td>May 8, 2026</td>
                            <td>Lab Results</td>
                            <td>Medical Lab</td>
                            <td><span class="status-badge status-active">Completed</span></td>
                            <td><a href="#" style="color: var(--primary-light); text-decoration: none; font-weight: 600;">View</a></td>
                        </tr>
                        <tr>
                            <td>April 30, 2026</td>
                            <td>Vaccination</td>
                            <td>Clinic Center</td>
                            <td><span class="status-badge status-active">Completed</span></td>
                            <td><a href="#" style="color: var(--primary-light); text-decoration: none; font-weight: 600;">View</a></td>
                        </tr>
                        <tr>
                            <td>April 20, 2026</td>
                            <td>X-Ray</td>
                            <td>Radiology Dept</td>
                            <td><span class="status-badge status-pending">Pending</span></td>
                            <td><a href="#" style="color: var(--primary-light); text-decoration: none; font-weight: 600;">View</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2026 Student Medical Record System. All rights reserved. Your health data is secure and protected.</p>
    </div>

    <script>
        // Prevent caching of this page
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        // Optional: Log out on tab close for maximum security
        // window.addEventListener('beforeunload', function() {
        //     // Send logout request if needed
        // });
    </script>
</body>
</html>
