<!-- Landing Banner -->
<section class="sub">
    <div class="container--xl text-center">
        <a href="/" class="landing-banner__logo-link">
            <img src="{$assets_dir}img/logo--black.png" alt="" class="landing-banner__logo">
        </a>
        <h1 class="landing-banner__title has_particles">
            <span id="particles-js"></span>
            <span class="title_text">{$title}<span>
        </h1>
      </div>
</section>

	<!-- Blocks -->
	<section class="landing-blocks">
    <div class="landing-blocks__container container--xl flex-grid">
      <ul class="tabs">
          <li class="tabs__tab-item">
              <a href="#" class="tabs__tab-item-link" data-tab="characters">Characters</a>
          </li>
          <li class="tabs__tab-item">
              <a href="#" class="tabs__tab-item-link" data-tab="posts">Forum Posts</a>
          </li>
          <li class="tabs__tab-item">
              <a href="#" class="tabs__tab-item-link" data-tab="replies">Forum Replies</a>
          </li>
      </ul>
      <div class="tabs__tab-content current full box" data-tab="characters">
        <div class="content-area">
          <h3>These are all the known PCs and NPCs played by this person.</h3>
          {if $characters}
            <div class="flex-grid">
      	    	{foreach from=$characters item=block}
      		        <div class="landing-blocks__block box med-1of2 lg-1of2 xl-1of2">
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
            {/if}
        </div>
      </div>
      <div class="tabs__tab-content full box" data-tab="posts">
        <div class="content-area">
          <h3>This table lists all forum posts where this player is active.</h3>
          <div id="bbpress-forums">
            {bbp_get_template_part( 'loop', 'topics' )}
          </div>
        </div>
      </div>
      <div class="tabs__tab-content full box" data-tab="replies">
        <div class="content-area">
          <h3>This table lists all forum posts made by the player.</h3>
          <div id="bbpress-forums">
            {bbp_get_template_part( 'loop', 'replies' )}
          </div>
        </div>
      </div>
    </div>
	</section>
