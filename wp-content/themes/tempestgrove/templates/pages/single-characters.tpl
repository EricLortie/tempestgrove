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

<!-- characters -->
<section class="landing-characters">
  <div class="landing-characters__container container--xl flex-grid">
    <div class="landing-characters__character box med-1of2">

      <div class="landing-characters__character-inner">
          <a href="{$character->permalink}" class="landing-characters__character-image-link">
              <img data-src="{$character->thumbnail_url}" alt="{$character->post_title}" class="landing-characters__character-image">
          </a>
      </div>
    </div>

    <div class="landing-characters__character box med-1of2">

      <div class="landing-characters__character-copy">

          {if $character->fields['race'] || $character->fields['class']}
            <h2 class="landing-characters__character-title">{$character->fields['race']} {$character->fields['class']}</h2>
          {/if}

          <p>{the_content()}</p>

          <a href="/characters" class="landing-characters__character-cta button--basic--outline small" title="Back to Characters" >
            <span>Back to Characters</span>
          </a>

          <a href="#" id="popup-bio-form" title="Update Character"data-dialog="character-form" class="dialog__trigger landing-characters__character-cta button--basic--outline small" title="Back to Characters" >
            <span>Suggest an Edit</span>
          </a>
      </div>
    </div>
  </div>
</section>

<div class="dialog__overlay dialog__close"></div>
<div class="dialog" data-dialog="character-form">
    <!-- Close Icon -->
    <a href="#" class="dialog__close-button dialog__close">
        X
    </a>
    <!-- Content -->
    <h3>Suggest Character Biography</h3>

    <p>You can suggest additions or changes to this character by submitting this form. This should only be publicly known information. Think of this as "Here's what you may have heard about this character around town."</p>
    {do_shortcode('[contact-form-7 id="421" title="Character Biography Form"]')}

</div>
