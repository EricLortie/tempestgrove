{include file='../includes/landing_banner.tpl'}

	<!-- Blocks -->
	<section class="landing-blocks">
    <div class="landing-blocks__container container--xl flex-grid">
      <ul class="tabs">
				{foreach from=$results key=k item=block}
          <li class="tabs__tab-item">
              <a href="#" class="tabs__tab-item-link game_tab_header" data-tab="{$k}">{$block['name']}</a>
          </li>
				{/foreach}
      </ul>

			{foreach from=$results key=k item=block}
	      <div class="tabs__tab-content {if $results@iteration == 1}current{/if} full box" data-tab="{$k}">
	        <div class="content-area flex-grid">
						<div class="full box">
							<h3 class="game_header">{$block['name']}</h3>
						</div>
						{foreach from=$block['votes'] item=char}
							<div class="small-1of1 med-4of12 box rp_awards_content">
								<h2 class="character_name">{$char['name']}</h2>
								<h4 class="vote_count">Votes: {$char['descriptions']|@count}</h4>
							</div>
							<div class="small-1of1 med-8of12 box rp_awards_content">
								{foreach from=$char['descriptions'] item=vote}
									<p class="vote_description">{$vote}</p>
								{/foreach}
							</div>
						{/foreach}
	        </div>
	      </div>
			{/foreach}

    </div>
	</section>
