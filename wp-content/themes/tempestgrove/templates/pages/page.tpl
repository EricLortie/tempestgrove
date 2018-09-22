<!-- Landing Banner -->
<section class="sub">
    <div class="container--xl text-center">
        <a href="/" class="landing-banner__logo-link">
            <img src="{$assets_dir}img/logo--black.png" alt="" class="landing-banner__logo">
        </a>
        {if $breadcrumbs}
            <ul class="breadcrumbs">
                {$breadcrumbs}
            </ul>
        {/if}
        <h1 class="landing-banner__title">{$title}</h1>
    </div>
</section>

<!-- blocks -->
<section class="landing-blocks">
  <div class="landing-blocks__container container--xl flex-grid">
    <div class="landing-blocks__character box">

      <div class="landing-blocks__character-inner">

            {the_content()}

      </div>
    </div>
  </div>
</section>
