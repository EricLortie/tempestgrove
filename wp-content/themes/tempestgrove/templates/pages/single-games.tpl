<!-- Landing Banner -->
<section class="sub">
    <div class="container--xl text-center">
        <a href="/" class="landing-banner__logo-link">
            <img src="{$assets_dir}img/logo--black.png" alt="" class="landing-banner__logo">
        </a>
        <h1 class="landing-banner__title has_particles">
            <span id="particles-js"></span>
            <span class="title_text">{$event->post_title}<span>
        </h1>
    </div>
</section>
<div class="sphere-row flex-grid">

  <div class="small-1of1 med-4of12 box">

    <a href="{$event->permalink}" class="landing-characters__character-image-link">
        <img data-src="{$event->fields['event_photo']}" alt="{$event->post_title}" class="landing-characters__character-image">
    </a>

  </div>

  <div class="small-1of1 med-8of12 box">

    <div class="builder-photo__block">
      <div class="builder-photo__content">
        <div class="builder-photo__content-inner">

            <h3 class="landing-characters__character-title">START: {$event->fields['event_start']|date_format:"%A, %B %e @ %H:%M"}</h3>
            <h3 class="landing-characters__character-title">END: {$event->fields['event_end']|date_format:"%A, %B %e @ %H:%M"}</h3>

            {if $event_has_passed}
              <p>{$event->fields['preview']}</p>
            {else}
              <p>{$event->fields['summary']}</p>
            {/if}

            <a href="/events" class="landing-characters__character-cta button--basic--outline small" title="Back to Events" >
              <span>Back to Events</span>
            </a>

        </div>
      </div>
    </div>

  </div>
</div>


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
