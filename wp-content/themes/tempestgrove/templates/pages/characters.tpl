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

{if $characters}
	<!-- Blocks -->
	<section class="landing-blocks">
	    <div class="landing-blocks__container container--xl flex-grid">
	    	{foreach from=$characters item=block}
		        <div class="landing-blocks__block box med-1of2 lg-1of3 xl-1of4">
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
                              <h5 class="landing-blocks__block-title">Played By: <a href="{$block->fields['player']->user_url}">{$block->fields['player']['user_firstname']}</a></h5>
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
