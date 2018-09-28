{include file='../includes/landing_banner.tpl'}

{if $next_game}
<div class="sphere-row flex-grid">
<h3 class="landing-banner__subtitle">This is the next game. For all past and future games keep scrolling.</h3>
  <div class="small-1of1 med-4of12 box">

    <a href="{$next_game->permalink}" class="landing-characters__character-image-link">
        <img data-src="{$next_game->fields['event_photo']}" alt="{$next_game->post_title}" class="landing-characters__character-image">
    </a>

  </div>

  <div class="small-1of1 med-8of12 box">

    <div class="builder-photo__block">
      <div class="builder-photo__content">
        <div class="builder-photo__content-inner game_content">
            <h2>{$next_game->time_remaining}</h2>

            <h5 class="landing-characters__character-title"><span class="white-text">START:</span> {$next_game->fields['event_start']|date_format:"%A, %B %e @ %H:%M"}</h5>
            <h5 class="landing-characters__character-title"><span class="white-text">END:</span> {$next_game->fields['event_end']|date_format:"%A, %B %e @ %H:%M"}</h5>

            <p>{$next_game->fields['preview']}</p>

        </div>
      </div>
    </div>

  </div>
</div>
{/if}

{if $games}
	<!-- Blocks -->
	<section class="landing-blocks">
	    <div class="landing-blocks__container container--xl flex-grid">
	    	{foreach from=$games item=block}
		        <div class="landing-blocks__block box med-1of2 lg-1of2 xl-1of3">
		            <div class="landing-blocks__block-inner">
		                <a href="{$block->permalink}" class="landing-blocks__block-image-link">
		                    <img data-src="{$block->fields['event_photo']}" alt="{$block->post_title}" class="landing-blocks__block-image">
		                </a>
		                <div class="landing-blocks__block-content">
		                    <div class="landing-blocks__block-copy game_content">
                          <h2>{$block->time_remaining}</h2>
                          <h5 class="landing-characters__character-title">START: {$block->fields['event_start']|date_format:"%A, %B %e @ %H:%M"}</h5>
                          <h5 class="landing-characters__character-title">END: {$block->fields['event_end']|date_format:"%A, %B %e @ %H:%M"}</h5>

                          <p>{$block->fields['preview']}</p>

		                    </div>
		                    {if $block->permalink}
		                    	<a href="{$block->permalink}" class="landing-blocks__block-cta button--basic--outline small">
		                    		<span>LEARN MORE</span>
		                    	</a>
		                    {/if}
		                </div>
		            </div>
		        </div>
	        {/foreach}
	    </div>
	</section>
{/if}
