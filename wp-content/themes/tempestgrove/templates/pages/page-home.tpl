<!-- Landing Banner -->
<section class="landing-banner" style="background-image: url('https://tempestgrove.com//wp-content/uploads/2017/09/37113065645_52718149af_k.jpg;">

    <div class="landing-banner__block">
        <h1 class="landing-banner__title has-particles">
            RUN<span>.</span> FIGHT<span>.</span> HIDE<span>.</span>
        </h1>
        <div class="landing-banner__content">
            <div class="landing-banner__content-inner">
                <p>Your life is your adventure. Save the day. Face your foes. Master your craft. Create your story.</p>
              	<a href="/about" class="landing-banner__cta button--basic--outline">
              		<span>LEARN MORE</span>
              	</a>
            </div>
        </div>
    </div>
</section>

<section class="services-blocks">
  <div class="landing-blocks__container container--xl flex-grid">
    <div class="landing-banner__border"></div>
    <div class="service box med-1of3">
      <div class="service-icon">
        <i class="fa fa-pencil-alt"></i>
      </div><!--/.service-icon-->
      <div class="service-title">Roleplaying</div><!--/.service-title-->
      <div class="service-entry">
        Become a character in an immersive world full of interesting people, fantastic stories and exciting events! Build out a costume and an ongoing story for your characters.
      </div>
    </div>
    <div class="service box med-1of3">
      <div class="service-icon">
        <i class="fa fa-shield-alt"></i>
      </div><!--/.service-icon-->
      <div class="service-title">Combat</div><!--/.service-title-->
      <div class="service-entry">
        Engage your enemies in combat using foam weapons and armour. Cast magic spells and rituals. Charge into battle, use stealth or talk your way out of fights.</div>
    </div>
    <div class="service box med-1of3">
      <div class="service-icon">
        <i class="fa fa-magic"></i>
      </div><!--/.service-icon-->
    <div class="service-title">Adventure</div><!--/.service-title-->
    <div class="service-entry">
      Months long story arcs planned out by our shaper team will keep you engaged while you develop your own character as part of a community of friends and foes.  </div>
    </div>
  </div>
</section>

{if $characters}
	<!-- Blocks -->
	<section class="landing-blocks">
	    <div class="landing-blocks__container container--xl flex-grid">
	    	{foreach from=$characters item=block}
		        <div class="landing-blocks__block box med-1of2 lg-1of4 xl-1of4">
		            <div class="landing-blocks__block-inner">
		                <a href="{$block->permalink}" class="landing-blocks__block-image-link">
		                    <img data-src="{$block->thumbnail_url}" alt="{$block->post_title}" class="landing-blocks__block-image">
		                </a>
		                <div class="landing-blocks__block-content">
		                    <div class="landing-blocks__block-copy">
		                        <h4 class="landing-blocks__block-title">{$block->post_title}</h4>
		                        {if $block->fields['race'] || $block->fields['class']}
                              <h5 class="landing-blocks__block-title">{$block->fields['race']} {$block->fields['class']}</h5>
                            {/if}
		                        {if $block->fields['player']}
                              <h5 class="landing-blocks__block-title player_name">Played By: <a href="{$block->profile_url}">{$block->fields['player']['user_firstname']}</a></h5>
                            {/if}
		                        <p>{$block->post_excerpt}</p>
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
