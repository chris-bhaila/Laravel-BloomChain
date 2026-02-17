<style>
    /* All your existing CSS code goes here */
    .percentage-text {
        font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        dominant-baseline: middle;
        transition: font-size 0.2s ease;
    }

    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    @media (max-width: 640px) {
        .percentage-text {
            font-size: 6px !important;
        }
    }

    .chart-container {
        position: relative;
        height: 100%;
        width: 100%;
    }

    .status-badge {
        transition: all 0.2s ease;
    }

    .status-badge:hover {
        transform: scale(1.05);
    }

    /* Table optimizations */
    .overflow-x-auto {
        -webkit-overflow-scrolling: touch;
        max-width: 100vw;
        margin-left: auto;
        margin-right: auto;
        isolation: isolate;
    }

    /* Progress circle animations */
    [data-progress] {
        transition: stroke-dasharray 0.5s ease;
    }

    /* Enhanced mobile styles */
    @media (max-width: 640px) {
        input[type="date"],
        button {
            min-height: 40px;
        }
    }

    /* Sales Toggle Styles */
    .view-toggle-container {
        background-color: #f3f4f6;
        padding: 0.25rem;
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
        display: inline-flex;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .view-toggle {
        position: relative;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #6b7280;
        border-radius: 0.375rem;
        transition: all 0.2s ease;
        cursor: pointer;
        user-select: none;
        min-width: 90px;
        text-align: center;
    }

    .view-toggle:hover:not(.active) {
        color: #4b5563;
        background-color: rgba(255, 255, 255, 0.7);
    }

    .view-toggle.active {
        background-color: #ffffff;
        color: #2563eb;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        font-weight: 600;
    }

    .view-toggle.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 50%;
        transform: translateX(-50%);
        width: 20px;
        height: 2px;
        background-color: #2563eb;
        border-radius: 2px;
        transition: width 0.2s ease;
    }

    .view-toggle.active:hover::after {
        width: 30px;
    }

    /* Responsive adjustments */
    @media (max-width: 640px) {
        .view-toggle {
            min-width: 80px;
            padding: 0.375rem 0.75rem;
        }
    }

    /* Enhanced Mobile Responsive Styles */
    @media (max-width: 768px) {
        .chart-container {
            height: 300px; /* Reduced height for mobile */
            min-height: auto;
        }

        .percentage-text {
            font-size: 8px !important;
        }

        /* Improve table readability on mobile */
        .overflow-x-auto {
            margin: 0 -1rem; /* Negative margin to allow full-width scrolling */
            padding: 0 1rem;
        }

        /* Adjust card layouts */
        .stats-card {
            min-width: 100%;
            margin-bottom: 1rem;
        }

        /* Adjust progress circles for mobile */
        .progress-circle {
            width: 60px !important;
            height: 60px !important;
        }

        /* Improve form controls spacing */
        .form-group {
            margin-bottom: 1rem;
        }

        select, input[type="date"] {
            width: 100%;
            margin-bottom: 0.5rem;
        }
    }

    /* Additional Mobile Optimizations */
    @media (max-width: 640px) {
        .view-toggle-container {
            width: 100%;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .view-toggle {
            flex: 1;
            min-width: auto;
            padding: 0.5rem;
            font-size: 0.75rem;
        }

        /* Improve table display on small screens */
        table {
            display: block;
            width: 100%;
        }

        td, th {
            padding: 0.5rem 0.75rem;
            font-size: 0.75rem;
        }

        /* Stack filters on mobile */
        .filters-container {
            flex-direction: column;
            gap: 0.5rem;
        }

        /* Adjust status badges */
        .status-badge {
            padding: 0.25rem 0.5rem;
            font-size: 0.65rem;
        }
    }

    /* Improved Loading State */
    .loading-overlay {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(2px);
    }

    /* Smooth Transitions */
    .chart-transition {
        transition: all 0.3s ease-in-out;
    }

    /* ... rest of your CSS code ... */
</style> 