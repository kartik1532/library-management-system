document.addEventListener('DOMContentLoaded', function () {

    /*
     * ============================================================
     * DELETE CONFIRMATION
     * ============================================================
     */

    document.querySelectorAll('.delete-form').forEach(function (form) {

        form.addEventListener('submit', function (event) {

            const confirmed = window.confirm(
                'Are you sure you want to delete this record?'
            );

            if (!confirmed) {
                event.preventDefault();
            }

        });

    });


    /*
     * ============================================================
     * AUTOMATICALLY HIDE BOOTSTRAP ALERTS
     * ============================================================
     */

    setTimeout(function () {

        document
            .querySelectorAll('.alert-dismissible')
            .forEach(function (alert) {

                const closeButton =
                    alert.querySelector('.btn-close');

                if (closeButton) {
                    closeButton.click();
                }

            });

    }, 5000);


    /*
     * ============================================================
     * GLOBAL LIVE SEARCH / AUTOCOMPLETE
     * ============================================================
     *
     * Any search input with:
     *
     * data-live-search
     * data-autocomplete="books"
     *
     * automatically gets live autocomplete functionality.
     *
     * Supported types:
     *
     * books
     * authors
     * categories
     * members
     * borrowings
     * fines
     *
     * ============================================================
     */

    const searchInputs = document.querySelectorAll(
        '[data-live-search][data-autocomplete]'
    );


    /*
     * Store debounce timers separately for each
     * search input.
     */

    const searchDebounce = new WeakMap();


    /*
     * ============================================================
     * HIDE SUGGESTIONS
     * ============================================================
     */

    function hideSuggestions(input) {

        const wrapper =
            input.closest('.autocomplete-wrapper');

        const dropdown = wrapper
            ? wrapper.querySelector(
                '.autocomplete-suggestions'
            )
            : null;

        if (dropdown) {

            dropdown.style.display = 'none';

            dropdown.innerHTML = '';
        }
    }


    /*
     * ============================================================
     * SUBMIT SEARCH
     * ============================================================
     */

    function submitSearch(input, value) {

        const form = input.closest('form');

        if (!form) {
            return;
        }

        input.value = value;

        if (
            typeof form.requestSubmit === 'function'
        ) {

            form.requestSubmit();

        } else {

            form.submit();

        }
    }


    /*
     * ============================================================
     * RENDER AUTOCOMPLETE RESULTS
     * ============================================================
     */

    function renderSuggestions(
        input,
        results
    ) {

        const wrapper =
            input.closest('.autocomplete-wrapper');

        if (!wrapper) {
            return;
        }


        let dropdown =
            wrapper.querySelector(
                '.autocomplete-suggestions'
            );


        /*
         * Create dropdown if it doesn't
         * already exist.
         */

        if (!dropdown) {

            dropdown =
                document.createElement('div');

            dropdown.className =
                'autocomplete-suggestions';

            dropdown.setAttribute(
                'role',
                'listbox'
            );

            wrapper.appendChild(dropdown);
        }


        /*
         * Clear old results.
         */

        dropdown.innerHTML = '';


        /*
         * No results.
         */

        if (!results.length) {

            const empty =
                document.createElement('div');

            empty.className =
                'autocomplete-empty';

            empty.textContent =
                'No matching results found.';

            dropdown.appendChild(empty);

            dropdown.style.display = 'block';

            return;
        }


        /*
         * Create each suggestion.
         */

        results.forEach(function (result) {

            const button =
                document.createElement('button');


            button.type = 'button';


            button.className =
                'autocomplete-suggestion';


            button.setAttribute(
                'role',
                'option'
            );


            /*
             * Suggestion HTML.
             */

            button.innerHTML = `
                <span class="autocomplete-suggestion-icon">
                    <i class="bi bi-search"></i>
                </span>

                <span class="autocomplete-suggestion-content">

                    <span class="autocomplete-suggestion-label"></span>

                    <span class="autocomplete-suggestion-meta"></span>

                </span>
            `;


            /*
             * Main result text.
             */

            button.querySelector(
                '.autocomplete-suggestion-label'
            ).textContent =
                result.label ||
                result.value ||
                '';


            /*
             * Additional information.
             */

            button.querySelector(
                '.autocomplete-suggestion-meta'
            ).textContent =
                result.meta ||
                '';


            /*
             * Clicking suggestion.
             */

            button.addEventListener(
                'click',
                function () {

                    submitSearch(
                        input,
                        result.value ||
                        result.label ||
                        ''
                    );

                }
            );


            dropdown.appendChild(button);

        });


        dropdown.style.display = 'block';
    }


    /*
     * ============================================================
     * LOAD SUGGESTIONS FROM LARAVEL
     * ============================================================
     */

    async function loadSuggestions(input) {

        const query =
            input.value.trim();


        const type =
            input.dataset.autocomplete;


        /*
         * Empty input.
         */

        if (!query) {

            hideSuggestions(input);

            return;
        }


        try {

            const url =
                new URL(
                    '/search/suggestions',
                    window.location.origin
                );


            url.searchParams.set(
                'q',
                query
            );


            url.searchParams.set(
                'type',
                type
            );


            const response =
                await fetch(
                    url,
                    {
                        headers: {
                            'Accept':
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest'
                        }
                    }
                );


            /*
             * Request failed.
             */

            if (!response.ok) {

                hideSuggestions(input);

                return;
            }


            const results =
                await response.json();


            /*
             * Ignore old AJAX response if the
             * user has already typed something else.
             */

            if (
                input.value.trim() !== query
            ) {

                return;
            }


            renderSuggestions(
                input,
                results
            );


        } catch (error) {

            hideSuggestions(input);

        }

    }


    /*
     * ============================================================
     * INITIALIZE ALL SEARCH INPUTS
     * ============================================================
     */

    searchInputs.forEach(function (input) {


        /*
         * --------------------------------------------------------
         * TYPING
         * --------------------------------------------------------
         *
         * Wait 180ms before sending the request.
         *
         * This prevents a request being sent for every
         * individual keyboard character.
         */

        input.addEventListener(
            'input',
            function () {

                clearTimeout(
                    searchDebounce.get(input)
                );


                searchDebounce.set(
                    input,

                    setTimeout(
                        function () {

                            loadSuggestions(
                                input
                            );

                        },
                        180
                    )
                );

            }
        );


        /*
         * --------------------------------------------------------
         * ESCAPE KEY
         * --------------------------------------------------------
         */

        input.addEventListener(
            'keydown',
            function (event) {

                if (event.key === 'Escape') {

                    hideSuggestions(input);

                }

            }
        );


        /*
         * --------------------------------------------------------
         * FOCUS
         * --------------------------------------------------------
         *
         * If the input already contains text,
         * show suggestions again.
         */

        input.addEventListener(
            'focus',
            function () {

                if (
                    input.value.trim()
                ) {

                    loadSuggestions(
                        input
                    );

                }

            }
        );


        /*
         * --------------------------------------------------------
         * FORM SUBMISSION
         * --------------------------------------------------------
         *
         * This is the important part for your requirement:
         *
         * 1. User clicks Search.
         * 2. Search value is preserved in a hidden input.
         * 3. Visible search input is immediately cleared.
         * 4. No Reset button is required.
         */

        const form =
            input.closest('form');


        if (form) {

            form.classList.add(
                'smart-search-form'
            );


            form.addEventListener(
                'submit',
                function () {

                    const value =
                        input.value.trim();


                    /*
                     * Remove old hidden search value.
                     */

                    const oldHidden =
                        form.querySelector(
                            'input[data-smart-search-hidden="true"]'
                        );


                    if (oldHidden) {
                        oldHidden.remove();
                    }


                    /*
                     * Preserve search value
                     * in hidden input.
                     */

                    if (value !== '') {

                        const hidden =
                            document.createElement(
                                'input'
                            );


                        hidden.type = 'hidden';


                        hidden.name = 'search';


                        hidden.value = value;


                        hidden.dataset.smartSearchHidden =
                            'true';


                        form.appendChild(
                            hidden
                        );
                    }


                    /*
                     * Remove the visible input's
                     * name so the empty value isn't
                     * submitted.
                     */

                    input.removeAttribute(
                        'name'
                    );


                    /*
                     * CLEAR SEARCH BAR.
                     */

                    input.value = '';


                    /*
                     * Hide autocomplete.
                     */

                    hideSuggestions(
                        input
                    );

                }
            );

        }

    });


    /*
     * ============================================================
     * CLICK OUTSIDE SEARCH
     * ============================================================
     *
     * Close autocomplete when user clicks elsewhere.
     */

    document.addEventListener(
        'click',
        function (event) {

            if (
                !event.target.closest(
                    '.autocomplete-wrapper'
                )
            ) {

                document
                    .querySelectorAll(
                        '.autocomplete-suggestions'
                    )
                    .forEach(
                        function (dropdown) {

                            dropdown.style.display =
                                'none';

                        }
                    );
            }

        }
    );

});