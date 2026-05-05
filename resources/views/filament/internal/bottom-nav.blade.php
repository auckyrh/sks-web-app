<style>
    #ip-bnav {
        display: none;
        position: fixed;
        bottom: 0; left: 0; right: 0;
        height: 3.75rem;
        background: #fff;
        border-top: 1px solid #fef3c7;
        box-shadow: 0 -4px 16px rgba(180,83,9,0.08);
        z-index: 99;
        align-items: stretch;
    }
    .dark #ip-bnav {
        background: rgb(17,24,39);
        border-top-color: rgba(251,191,36,0.12);
        box-shadow: 0 -4px 16px rgba(0,0,0,0.25);
    }
    /* show only on mobile — hide when Filament sidebar is visible (≥1024px) */
    @media (max-width: 1023px) {
        #ip-bnav { display: flex; }
        /* push page content up so last card isn't hidden behind nav */
        .fi-main-ctn { padding-bottom: 4.5rem !important; }
    }

    .ip-bnav-item {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 0.2rem;
        text-decoration: none;
        color: #9ca3af;
        font-size: 0.625rem;
        font-weight: 600;
        letter-spacing: 0.02em;
        transition: color 0.15s;
        -webkit-tap-highlight-color: transparent;
    }
    .dark .ip-bnav-item { color: #6b7280; }

    .ip-bnav-item svg { width: 1.375rem; height: 1.375rem; }

    .ip-bnav-item.active {
        color: #d97706;
    }
    .dark .ip-bnav-item.active { color: #fbbf24; }

    /* active dot indicator */
    .ip-bnav-item.active::after {
        content: '';
        display: block;
        width: 0.3rem; height: 0.3rem;
        border-radius: 50%;
        background: #d97706;
        margin-top: 0.1rem;
    }
    .dark .ip-bnav-item.active::after { background: #fbbf24; }
</style>

<nav id="ip-bnav" role="navigation" aria-label="Bottom navigation">
    <a href="/internal/dashboard" class="ip-bnav-item" data-path="/internal/dashboard">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
            <path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
        </svg>
        Home
    </a>
    <a href="/internal/my-division" class="ip-bnav-item" data-path="/internal/my-division">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 1 1-1.49-.158 5.25 5.25 0 0 0-10.436 0 .75.75 0 0 1-1.49.158 6.745 6.745 0 0 1 1.017-4.381ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0-.42-1.395 9.314 9.314 0 0 1-3.96.57.75.75 0 0 0-.447 1.72ZM6.75 19.128l.001.144a2.25 2.25 0 0 0 .233.96 10.088 10.088 0 0 1-5.06-1.01.75.75 0 0 1 .42-1.395 9.315 9.315 0 0 0 3.96.57.75.75 0 0 1 .447 1.72Z" clip-rule="evenodd" />
        </svg>
        Division
    </a>
    <a href="/internal/profile" class="ip-bnav-item" data-path="/internal/profile">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
        </svg>
        Profile
    </a>
</nav>

<script>
(function () {
    function setActive() {
        var path = window.location.pathname;
        document.querySelectorAll('.ip-bnav-item').forEach(function (a) {
            var itemPath = a.getAttribute('data-path');
            a.classList.toggle('active', path === itemPath || path.startsWith(itemPath + '/'));
        });
    }
    setActive();
    document.addEventListener('livewire:navigated', setActive);
})();
</script>
