<?php

namespace Palasthotel\WordPress\Headless;

class Dashboard extends Components\Component {
	public function onCreate() {
		parent::onCreate();
		add_action('wp_dashboard_setup', [$this, 'setup']);
	}

	public function setup(){
        if(!current_user_can('edit_posts')) return;

        wp_add_dashboard_widget(
            Plugin::DOMAIN,
            __("Headless", Plugin::DOMAIN),
            array($this, 'render')
        );
	}

	public function render(){
        $timeFormat = get_option('time_format');
        $dateFormat = get_option('date_format');

        $lastRevalidationRun = $this->plugin->schedule->getLastRevalidationRun();
        $nextRevalidationRun = $this->plugin->schedule->getNextSchedule();

		$frontends = $this->plugin->headquarter->getFrontends();
        $ajaxUrl = admin_url('admin-ajax.php');
		?>
            <p><strong>Automatic revalidation</strong></p>
            <p>Last revalidation run: <span data-headless-timestamp="<?= $lastRevalidationRun; ?>">
                    <?= date_i18n($dateFormat,$lastRevalidationRun)." ".date_i18n($timeFormat, $lastRevalidationRun); ?>
                </span></p>

            <p>Next revalidation run:  <span data-headless-timestamp="<?= $nextRevalidationRun; ?>">
                <?= ($nextRevalidationRun === false) ? "🚨 Broken" : date_i18n($dateFormat, $nextRevalidationRun)." ".date_i18n($timeFormat, $nextRevalidationRun); ?>
                </span></p>

            <p>Pending posts to be revalidated: <?= $this->plugin->dbRevalidation->countPendingPosts(); ?></p>
            <p>Pending comments to be revalidated: <?= $this->plugin->dbRevalidation->countPendingComments(); ?></p>

            <button class="button button-secondary" id="headless-revalidate-pending">Revalidate pending</button>
            <span id="headless-revalidate-pending-spinner" class="spinner"></span>

            <script>
                document.querySelectorAll("[data-headless-timestamp]").forEach((el) => {
                    const timestamp = el.getAttribute("data-headless-timestamp");
                    console.debug("headless timestamp", timestamp, el);
                    console.debug(Intl.DateTimeFormat().format(parseInt(timestamp) * 1000));
                });
                const button = document.getElementById("headless-revalidate-pending");
                const spinner = document.getElementById("headless-revalidate-pending-spinner");

                button.addEventListener("click", (e)=> {
                    e.preventDefault();
                    console.debug(button);
                    button.disabled = true;
                    spinner.classList.add("is-active");
                    fetch("<?= $ajaxUrl ?>?action=headless_revalidate_pending")
                        .then(res => res.json())
                        .then(console.debug)
                        .finally(()=>{
                            spinner.classList.remove("is-active");
                            button.disabled = false;
                        });
                })
            </script>

            <hr />

            <p><strong>Manual revalidation</strong></p>
            <ul>
                <?php
                foreach ($frontends as $index => $frontend){
                    $basePath = untrailingslashit($frontend->getBaseUrl());
                    echo "<li data-headless-frontend='$index'>";
                    echo "$basePath/<span data-path ";
                    echo "style='padding: 4px; background: #2271b1; color: white; border-radius: 2px; margin-inline: 2px;'";
                    echo "></span>";
                    echo " <span data-message></span>";
                    echo "</li>";
                }
                ?>
            </ul>
            <form method="post" id="headless-revalidate-form">
		        <input type="text" name="headless_invalidate_path" placeholder="path/to/invalidate" />
                <button class="button button-secondary">Revalidate cache</button>
                <span class="spinner"></span>
            </form>
            <script>
                (async ()=>{

                    const revalidateFrontendPath = async (frontend, path) => {
                        const response = await fetch(
                            `<?= $ajaxUrl ?>?action=headless_revalidate&path=${path}&frontend=${frontend}`
                        );
                        return await response.json();
                    }

                    const queryForm = ()=>{
                        return document.getElementById("headless-revalidate-form");
                    }

                    const queryInput = (parent = document)=> {
                        return parent.querySelector("[name=headless_invalidate_path]")
                    }

                    const setFormDisabled = (form, isDisabled) => {
                        if(isDisabled){
                            queryInput(form).setAttribute("disabled","disabled");
                            querySubmitButton(form).setAttribute("disabled","disabled");
                        } else {
                            queryInput(form).removeAttribute("disabled");
                            querySubmitButton(form).removeAttribute("disabled");
                        }
                    }

                    const setIsLoading = (form, isLoading) => {
                        if(isLoading){
                            form.querySelector(".spinner").classList.add("is-active");
                        } else {
                            form.querySelector(".spinner").classList.remove("is-active");
                        }
                    }

                    const querySubmitButton = (form)=> {
                        return form.querySelector("button")
                    }

                    const queryFrontend = (frontend) => {
                        return document.querySelector(`[data-headless-frontend="${frontend}"]`)
                    };

                    const frontendMessage = (frontend, value) => {
                        frontend.querySelector("[data-message]").innerText = value;
                    }

                    const frontendPath = (frontend, value) => {
                        frontend.querySelector("[data-path]").innerText = value;
                    }

                    const form = queryForm();
                    const input = queryInput(form);
                    form.addEventListener("submit", (e)=>{
                        e.preventDefault();
                        setFormDisabled(form, true);
                        setIsLoading(form, true);

                        const path = input.value;
                        const pathEncoded = encodeURIComponent("/"+path);
                        const frontends = Array.from(document.querySelectorAll("[data-headless-frontend]"));

                        frontends.forEach(f => {
                            frontendMessage(f, "🧹");
                            frontendPath(f, path);
                        });

                        const promises = frontends.map(el => {
                            const frontend = el.getAttribute("data-headless-frontend");
                            return revalidateFrontendPath(frontend, pathEncoded)
                        });

                        Promise.all(promises)
                            .then((responses) => {
                                responses.forEach((json, index) =>{
                                    frontendMessage(
                                        queryFrontend(index),
                                        json.success ? "✅" : "🚨"
                                    )
                                })
                            })
                            .finally(()=>{
                                setFormDisabled(form, false);
                                setIsLoading(form, false);
                            })

                    })
                })();
            </script>
		<?php
	}
}
