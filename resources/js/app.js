document.addEventListener("DOMContentLoaded", function () {

    /* =====================================================
       SIDEBAR ELEMENTS
    ===================================================== */

    const sidebar = document.getElementById("adminSidebar");
    const sidebarToggle = document.getElementById("sidebarToggle");
    const sidebarOverlay = document.getElementById("sidebarOverlay");
    const sidebarCollapse = document.getElementById("sidebarCollapse");


    /* =====================================================
       MOBILE SIDEBAR
    ===================================================== */

    function openMobileSidebar() {

        if (!sidebar) return;

        sidebar.classList.add("show");

        if (sidebarOverlay) {
            sidebarOverlay.classList.add("show");
        }

        document.body.classList.add("sidebar-open");
    }


    function closeMobileSidebar() {

        if (!sidebar) return;

        sidebar.classList.remove("show");

        if (sidebarOverlay) {
            sidebarOverlay.classList.remove("show");
        }

        document.body.classList.remove("sidebar-open");
    }


    if (sidebarToggle) {

        sidebarToggle.addEventListener("click", function () {

            if (sidebar && sidebar.classList.contains("show")) {

                closeMobileSidebar();

            } else {

                openMobileSidebar();

            }

        });

    }


    /* =====================================================
       SIDEBAR OVERLAY
    ===================================================== */

    if (sidebarOverlay) {

        sidebarOverlay.addEventListener("click", function () {

            closeMobileSidebar();

        });

    }


    /* =====================================================
       DESKTOP SIDEBAR COLLAPSE
    ===================================================== */

    if (sidebarCollapse) {

        sidebarCollapse.addEventListener("click", function () {

            document.body.classList.toggle("sidebar-collapsed");

            const icon = sidebarCollapse.querySelector("i");

            if (icon) {

                if (
                    document.body.classList.contains(
                        "sidebar-collapsed"
                    )
                ) {

                    icon.classList.remove("bi-chevron-left");

                    icon.classList.add("bi-chevron-right");

                } else {

                    icon.classList.remove("bi-chevron-right");

                    icon.classList.add("bi-chevron-left");

                }

            }

        });

    }


    /* =====================================================
       SIDEBAR DROPDOWNS
    ===================================================== */

    const dropdownButtons =
        document.querySelectorAll(".sidebar-dropdown-toggle");


    dropdownButtons.forEach(function (button) {

        button.addEventListener("click", function () {

            const dropdown =
                button.closest(".sidebar-dropdown");

            if (!dropdown) return;

            const isOpen =
                dropdown.classList.contains("open");


            /* Close other dropdowns */

            document
                .querySelectorAll(".sidebar-dropdown.open")
                .forEach(function (otherDropdown) {

                    if (otherDropdown !== dropdown) {

                        otherDropdown.classList.remove("open");

                    }

                });


            /* Toggle current dropdown */

            if (isOpen) {

                dropdown.classList.remove("open");

            } else {

                dropdown.classList.add("open");

            }

        });

    });


    /* =====================================================
       CLOSE MOBILE SIDEBAR AFTER LINK CLICK
    ===================================================== */

    document
        .querySelectorAll(".sidebar-sublink, .sidebar-link")
        .forEach(function (link) {

            link.addEventListener("click", function () {

                if (window.innerWidth <= 991.98) {

                    closeMobileSidebar();

                }

            });

        });


    /* =====================================================
       WINDOW RESIZE
    ===================================================== */

    window.addEventListener("resize", function () {

        if (window.innerWidth > 991.98) {

            closeMobileSidebar();

        }

    });


    /* =====================================================
       SEARCH AUTOSUGGESTIONS
    ===================================================== */

    const searchInputs =
        document.querySelectorAll(
            "[data-live-search][data-autocomplete]"
        );


    searchInputs.forEach(function (input) {

        setupAutocomplete(input);

    });


    function setupAutocomplete(input) {

        const wrapper =
            input.closest(".autocomplete-wrapper");

        if (!wrapper) return;


        /*
         * Create suggestion box.
         * We create it automatically so you don't
         * have to manually add another div to Blade.
         */

        let suggestionBox =
            wrapper.querySelector(".autocomplete-suggestions");


        if (!suggestionBox) {

            suggestionBox =
                document.createElement("div");

            suggestionBox.className =
                "autocomplete-suggestions";

            wrapper.appendChild(suggestionBox);

        }


        let debounceTimer = null;


        /* =================================================
           INPUT EVENT
        ================================================= */

        input.addEventListener("input", function () {

            const query =
                input.value.trim();

            clearTimeout(debounceTimer);


            if (query.length === 0) {

                hideSuggestions(
                    suggestionBox
                );

                return;

            }


            /*
             * Wait 200ms before sending request.
             * This prevents sending a request for
             * every single keystroke immediately.
             */

            debounceTimer = setTimeout(
                function () {

                    fetchSuggestions(
                        input,
                        suggestionBox,
                        query
                    );

                },
                200
            );

        });


        /* =================================================
           FOCUS
        ================================================= */

        input.addEventListener("focus", function () {

            const query =
                input.value.trim();

            if (query.length > 0) {

                fetchSuggestions(
                    input,
                    suggestionBox,
                    query
                );

            }

        });


        /* =================================================
           ESCAPE KEY
        ================================================= */

        input.addEventListener("keydown", function (event) {

            if (event.key === "Escape") {

                hideSuggestions(
                    suggestionBox
                );

                input.blur();

            }

        });


        /* =================================================
           FORM SUBMIT
        ================================================= */

        const form = input.closest("form");

        if (form) {

            form.addEventListener(
                "submit",
                function () {

                    /*
                     * Keep the search functionality.
                     *
                     * Clear the visible input after
                     * submission, as requested.
                     */

                    setTimeout(function () {

                        input.value = "";

                        hideSuggestions(
                            suggestionBox
                        );

                    }, 0);

                }
            );

        }


        /* =================================================
           CLICK OUTSIDE
        ================================================= */

        document.addEventListener(
            "click",
            function (event) {

                if (!wrapper.contains(event.target)) {

                    hideSuggestions(
                        suggestionBox
                    );

                }

            }
        );

    }


    /* =====================================================
       FETCH SEARCH SUGGESTIONS
    ===================================================== */

    async function fetchSuggestions(
        input,
        suggestionBox,
        query
    ) {

        const type =
            input.dataset.autocomplete;


        if (!type || !query) {

            hideSuggestions(
                suggestionBox
            );

            return;

        }


        try {

            const url =
                new URL(
                    "/search/suggestions",
                    window.location.origin
                );


            url.searchParams.set(
                "q",
                query
            );


            url.searchParams.set(
                "type",
                type
            );


            const response =
                await fetch(
                    url.toString(),
                    {
                        method: "GET",

                        headers: {
                            "Accept":
                                "application/json",

                            "X-Requested-With":
                                "XMLHttpRequest"
                        },

                        credentials: "same-origin"
                    }
                );


            if (!response.ok) {

                throw new Error(
                    "Search request failed: " +
                    response.status
                );

            }


            const results =
                await response.json();


            /*
             * Make sure the user has not changed
             * the search text while the request
             * was running.
             */

            if (
                input.value.trim() !== query
            ) {

                return;

            }


            renderSuggestions(
                input,
                suggestionBox,
                results
            );


        } catch (error) {

            console.error(
                "Autocomplete error:",
                error
            );

            hideSuggestions(
                suggestionBox
            );

        }

    }


    /* =====================================================
       DISPLAY SUGGESTIONS
    ===================================================== */

    function renderSuggestions(
        input,
        suggestionBox,
        results
    ) {

        suggestionBox.innerHTML = "";


        if (
            !Array.isArray(results) ||
            results.length === 0
        ) {

            hideSuggestions(
                suggestionBox
            );

            return;

        }


        results.forEach(function (item) {

            const suggestion =
                document.createElement("button");


            suggestion.type =
                "button";


            suggestion.className =
                "autocomplete-suggestion";


            /*
             * Main suggestion text
             */

            const title =
                document.createElement("div");


            title.className =
                "autocomplete-suggestion-title";


            title.innerHTML =
                highlightMatch(
                    item.label || item.value || "",
                    input.value.trim()
                );


            suggestion.appendChild(
                title
            );


            /*
             * Additional information
             */

            if (item.meta) {

                const meta =
                    document.createElement("div");


                meta.className =
                    "autocomplete-suggestion-meta";


                meta.textContent =
                    item.meta;


                suggestion.appendChild(
                    meta
                );

            }


            /* =================================================
               CLICK SUGGESTION
            ================================================= */

            suggestion.addEventListener(
                "click",
                function () {

                    input.value =
                        item.value || "";


                    hideSuggestions(
                        suggestionBox
                    );


                    /*
                     * Submit the existing form.
                     */

                    const form =
                        input.closest("form");


                    if (form) {

                        form.requestSubmit();

                    }

                }
            );


            suggestionBox.appendChild(
                suggestion
            );

        });


        suggestionBox.classList.add(
            "show"
        );

    }


    /* =====================================================
       HIGHLIGHT SEARCH TEXT
    ===================================================== */

    function highlightMatch(
        text,
        search
    ) {

        if (!search) {

            return escapeHtml(text);

        }


        const escapedText =
            escapeHtml(text);


        const escapedSearch =
            escapeRegExp(search);


        const regex =
            new RegExp(
                "(" +
                escapedSearch +
                ")",
                "gi"
            );


        return escapedText.replace(
            regex,
            "<strong>$1</strong>"
        );

    }


    /* =====================================================
       ESCAPE HTML
    ===================================================== */

    function escapeHtml(value) {

        const div =
            document.createElement("div");

        div.textContent =
            value;

        return div.innerHTML;

    }


    /* =====================================================
       ESCAPE REGULAR EXPRESSION
    ===================================================== */

    function escapeRegExp(value) {

        return value.replace(
            /[.*+?^${}()|[\]\\]/g,
            "\\$&"
        );

    }


    /* =====================================================
       HIDE SUGGESTIONS
    ===================================================== */

    function hideSuggestions(
        suggestionBox
    ) {

        if (!suggestionBox) return;

        suggestionBox.classList.remove(
            "show"
        );

        suggestionBox.innerHTML = "";

    }

});