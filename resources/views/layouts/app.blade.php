<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Medical Record System')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #f0f4f8 0%, #d9e2ec 100%);
            color: #2c3e50;
            min-height: 100vh;
        }

        .header {
            background: linear-gradient(135deg, #0f3460 0%, #16213e 50%, #0f6a8a 100%);
            color: white;
            padding: 25px 0;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-logo {
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .logo-icon {
            background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%);
            width: 45px;
            height: 45px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 4px 12px rgba(0, 212, 255, 0.3);
        }

        .nav-tabs {
            display: flex;
            gap: 35px;
        }

        .nav-tab {
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
            padding: 8px 4px;
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 500;
            position: relative;
        }

        .nav-tab:hover {
            color: white;
        }

        .nav-tab.active {
            color: #00d4ff;
            border-bottom-color: #00d4ff;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 30px;
        }

        .page-header {
            margin-bottom: 40px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .page-header-content h1 {
            font-size: 36px;
            font-weight: 700;
            color: #0f3460;
            margin-bottom: 8px;
            background: linear-gradient(135deg, #0f3460 0%, #16213e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-subtitle {
            color: #546e7a;
            font-size: 14px;
            font-weight: 400;
        }

        .page-header-action {
            margin-bottom: 8px;
        }

        .metric-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .metric-card {
            background: white;
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.04);
            position: relative;
            overflow: hidden;
        }

        .metric-card:hover {
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            transform: translateY(-4px);
        }

        .metric-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #00d4ff 0%, #0099cc 100%);
        }

        .metric-card.fit::before {
            background: linear-gradient(90deg, #10b981 0%, #059669 100%);
        }

        .metric-card.warning::before {
            background: linear-gradient(90deg, #f59e0b 0%, #d97706 100%);
        }

        .metric-card.info::before {
            background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%);
        }

        .metric-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }

        .metric-label {
            font-size: 13px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .metric-icon {
            font-size: 28px;
            opacity: 0.2;
        }

        .metric-value {
            font-size: 42px;
            font-weight: 700;
            color: #0f3460;
            line-height: 1;
            margin-bottom: 8px;
        }

        .metric-subtitle {
            font-size: 12px;
            color: #9ca3af;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 22px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(0, 212, 255, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 212, 255, 0.4);
        }

        .btn-secondary {
            background: #e2e8f0;
            color: #0f3460;
            font-weight: 600;
        }

        .btn-secondary:hover {
            background: #cbd5e1;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }

        .card {
            background: white;
            border-radius: 14px;
            padding: 28px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.04);
        }

        .card:hover {
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        }

        .card-title {
            font-size: 18px;
            font-weight: 700;
            color: #0f3460;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-title-icon {
            font-size: 20px;
        }

        .stat-card {
            text-align: center;
            padding: 20px;
        }

        .stat-value {
            font-size: 40px;
            font-weight: 700;
            background: linear-gradient(135deg, #0099cc 0%, #00d4ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 12px 0;
        }

        .stat-label {
            font-size: 13px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .stat-icon {
            font-size: 36px;
            opacity: 0.25;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .search-bar {
            margin-bottom: 24px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .search-bar input {
            flex: 1;
            min-width: 250px;
            padding: 12px 16px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .search-bar input:focus {
            outline: none;
            border-color: #00d4ff;
            box-shadow: 0 0 0 4px rgba(0, 212, 255, 0.1);
        }

        .records-table {
            width: 100%;
            border-collapse: collapse;
        }

        .records-table thead {
            background: linear-gradient(135deg, #f8fafc 0%, #e8eef5 100%);
            border-bottom: 2px solid #e5e7eb;
        }

        .records-table th {
            padding: 16px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .records-table td {
            padding: 16px;
            border-bottom: 1px solid #e5e7eb;
        }

        .records-table tbody tr:hover {
            background: linear-gradient(135deg, #f0f9ff 0%, #f5f7fa 100%);
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .status-fit {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.1));
            color: #059669;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .status-not-fit {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.1));
            color: #dc2626;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .actions-cell {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .action-link {
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            background: none;
        }

        .action-edit {
            color: #0099cc;
            background: rgba(0, 212, 255, 0.1);
        }

        .action-edit:hover {
            background: rgba(0, 212, 255, 0.2);
            transform: translateY(-2px);
        }

        .action-delete {
            color: #dc2626;
            background: rgba(239, 68, 68, 0.1);
            cursor: pointer;
        }

        .action-delete:hover {
            background: rgba(239, 68, 68, 0.2);
            transform: translateY(-2px);
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #0f3460;
            font-size: 14px;
        }

        .form-input, .form-textarea, .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.3s ease;
        }

        .form-input:focus, .form-textarea:focus, .form-select:focus {
            outline: none;
            border-color: #00d4ff;
            box-shadow: 0 0 0 4px rgba(0, 212, 255, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 120px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .button-group {
            display: flex;
            gap: 12px;
            margin-top: 30px;
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
        }

        .empty-icon {
            font-size: 72px;
            opacity: 0.2;
            margin-bottom: 24px;
        }

        .empty-text {
            color: #6b7280;
            font-size: 18px;
            margin-bottom: 24px;
            font-weight: 500;
        }

        .alert {
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            gap: 12px;
            align-items: flex-start;
            border-left: 4px solid;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.05);
            color: #991b1b;
            border-left-color: #ef4444;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.05);
            color: #166534;
            border-left-color: #10b981;
        }

        .alert-icon {
            font-size: 18px;
            flex-shrink: 0;
        }

        .alert ul {
            list-style: none;
            padding: 0;
        }

        .alert li {
            margin-bottom: 4px;
        }

        .detail-section {
            margin-bottom: 24px;
        }

        .detail-label {
            font-weight: 600;
            color: #6b7280;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .detail-value {
            font-size: 16px;
            color: #0f3460;
            font-weight: 500;
        }

        .file-preview {
            padding: 16px;
            background: linear-gradient(135deg, #f0f9ff 0%, #f5f7fa 100%);
            border-radius: 8px;
            margin-top: 8px;
            font-size: 14px;
            border: 1px solid rgba(0, 212, 255, 0.2);
        }

        .file-preview a {
            color: #0099cc;
            text-decoration: none;
            font-weight: 600;
        }

        .file-preview a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }

            .nav-tabs {
                flex-wrap: wrap;
                gap: 16px;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .metric-container {
                grid-template-columns: 1fr;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .search-bar {
                flex-direction: column;
            }

            .search-bar input {
                min-width: auto;
            }

            .actions-cell {
                flex-direction: column;
            }

            .container {
                padding: 20px 16px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <div class="header-logo">
                <div class="logo-icon">🏥</div>
                <span>Medical Records</span>
            </div>
            <nav class="nav-tabs">
                <a href="{{ route('medical-records.index') }}" class="nav-tab @if(request()->routeIs('medical-records.index')) active @endif">Dashboard</a>
                <a href="{{ route('medical-records.create') }}" class="nav-tab @if(request()->routeIs('medical-records.create')) active @endif">Add Record</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-tab" style="background: none; border: none; cursor: pointer; padding: 8px 4px; font-size: 14px; font-weight: 500;">
                        <i class="fas fa-sign-out-alt" style="margin-right: 6px;"></i>Logout
                    </button>
                </form>
            </nav>
        </div>
    </div>

    <div class="container">
        @yield('content')
    </div>
</body>
</html>
