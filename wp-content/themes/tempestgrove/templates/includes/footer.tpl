    <!-- Footer -->
    <footer class="main-footer">
        <div class="main-footer__container container--xl">
            <div class="main-footer__layout flex-grid">
                <div class="main-footer__layout-item main-footer__logo-wrapper box lg-4of12">
                    <img src="{$assets_dir}img/logo--black.png" alt="Logo" class="main-footer__logo">
                </div>
                <div class="main-footer__layout-item box lg-8of12">
                    <div class="main-footer__group flex--justify-between flex--align-middle">

                        {if $footer_menu}
                            <!-- Quick Links -->
                            <nav class="main-footer__quick-links-wrapper">
                                <ul class="main-footer__quick-links">
                                    {foreach from=$footer_menu item=footer_menu_item}
                                        <li class="main-footer__quick-links-item">
                                            <a href="{$footer_menu_item->url}" class="main-footer__quick-links-item-link">
                                                {$footer_menu_item->title}
                                            </a>
                                        </li>
                                    {/foreach}
                                </ul>
                            </nav>
                        {/if}

                        {if $options.social_accounts}
                            <!-- Social Icons -->
                            <ul class="main-footer__social social-icons">
                                {foreach from=$options.social_accounts item=account}
                                    <li class="social-icons__item">
                                        <a href="{$account.link}" class="social-icons__item-link" target="_blank">
                                            <svg viewBox="0 0 24 24" class="core-icon--{$account.platform}">
                                                <use xlink:href="#core-icon--{$account.platform}"></use>
                                            </svg>
                                        </a>
                                    </li>
                                {/foreach}
                            </ul>
                        {/if}
                    </div>

                    <!-- Subfooter -->
                    <div class="main-footer__subfooter flex--justify-between flex--align-middle">
                        <p class="main-footer__subfooter-copyright">&copy; {$year} - Underworld LARP: Tempest Grove.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</div>
<!-- end .page-wrapper -->
