{include file='../includes/landing_banner.tpl'}

<div class="sphere-row flex-grid">

  <div class="small-1of1 med-4of12 box">

    <a href="{$character->permalink}" class="landing-characters__character-image-link">
        <img data-src="{$character->thumbnail_url}" alt="{$character->post_title}" class="landing-characters__character-image">
    </a>

  </div>

  <div class="small-1of1 med-8of12 box">

    <div class="builder-photo__block">
      <div class="builder-photo__content">
        <div class="builder-photo__content-inner">

            {if $character->fields['race'] || $character->fields['class']}
              <h2 class="landing-characters__character-title">{$character->fields['race']} {$character->fields['class']}</h2>
            {/if}

            {if $character->fields['player']}
              <h5 class="landing-blocks__block-title player_name">Played By: <a href="{$character->profile_url}">{$character->fields['player']['user_firstname']}</a></h5>
            {/if}

            <p>{$character->content}</p>

            <a href="/characters" class="landing-characters__character-cta button--basic--outline small" title="Back to Characters" >
              <span>Back to Characters</span>
            </a>

            <a href="#" id="popup-bio-form" title="Update Character"data-dialog="character-form" class="dialog__trigger landing-characters__character-cta button--basic--outline small" title="Back to Characters" >
              <span>Suggest an Edit</span>
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
