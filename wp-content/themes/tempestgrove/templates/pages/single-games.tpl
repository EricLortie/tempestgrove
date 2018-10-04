{include file='../includes/landing_banner.tpl'}

<div class="game-row flex-grid">

  <div class="small-1of1 med-4of12 box">

    <a href="{$game->permalink}" class="landing-characters__character-image-link">
        <img data-src="{$game->fields['event_photo']}" alt="{$game->post_title}" class="landing-characters__character-image">
    </a>

  </div>

  <div class="small-1of1 med-8of12 box">

    <div class="builder-photo__block">
      <div class="builder-photo__content">
        <div class="builder-photo__content-inner game_content">

            <h2>{$game->time_remaining}</h2>

            <h5 class="landing-characters__character-title"><span class="white-text">START:</span> {$game->fields['event_start']|date_format:"%A, %B %e @ %H:%M"}</h5>
            <h5 class="landing-characters__character-title"><span class="white-text">END:</span> {$game->fields['event_end']|date_format:"%A, %B %e @ %H:%M"}</h5>

            {if $event_has_passed || $game->fields['summary']}
              <p>{$game->fields['summary']}</p>
            {else}
              <p>{$game->fields['preview']}</p>
            {/if}

            <a href="/games" class="landing-characters__character-cta button--basic--outline small" title="Back to Games" >
              <span>Back to Games</span>
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
