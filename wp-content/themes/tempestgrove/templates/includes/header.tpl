<!--[if lt IE 10]>
    <p class="dated-browser-note">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<!-- Core Icons Include -->
<div class="core-icons" style="display:none;"></div>

<!-- Sidebar Menu -->
<div class="sidebar-nav__overlay"></div>
<ul class="sidebar-nav tab-bar--{$tab_bar_count}-up">
    <li class="sidebar-nav__item--logo">
        <a href="/" class="sidebar-nav__item-link">
            <img src="{$assets_dir}img/tg-logo-edited.png" class="aligncenter" alt="Tempest Grove LARP">
        </a>
    </li>

    {if $next_game}
      <li class="sidebar-nav__item sidebar-nav_countdown">
        <span id="game_date" style="display:none">{$next_game->fields['event_start']}</span>
        <a href="{$next_game->permalink}" class="sidebar-nav__item-link sidebar-nav__item-countdown">
          Next Game
          <div class="flex-grid" id="countdown">
            <div class="small-1of4 box"><span id="days"></span>D</div>
            <div class="small-1of4 box"><span id="hours"></span>H</div>
            <div class="small-1of4 box"><span id="minutes"></span>M</div>
            <div class="small-1of4 box"><span id="seconds"></span>S</div>
          </div>
        </a>
      </li>
    {/if}

    {foreach from=$main_menu item=item}
          <li class="sidebar-nav__item{if $item->mobile_more}--more in-tab-bar{/if} {if $item->in_tab_bar && !$item->mobile_more}in-tab-bar{/if}">
              <a
                  {if $item->children}href="#"{else}href="{$item->url}"{/if}
                  class="sidebar-nav__item-link {if $item->mobile_more}more-menu-toggle{/if}"
                  {if $item->children && !$item->mobile_more}
                      data-sidebar-pane="pane-{$item->ID}"
                  {/if}

              >
                  <span class="sidebar-nav__item-text">{$item->title}</span>
              </a>
              {if $item->mobile_more}
              	<ul class="sidebar-nav__more-menu">
              		{foreach from=$item->children item=more_child}
              			<li class="sidebar-nav__more-menu-item">
              				<a href="{$more_child->url}" class="sidebar-nav__more-menu-item-link">{$more_child->title}</a>
              			</li>
              		{/foreach}
              	</ul>
              {/if}
          </li>
      {/foreach}

    <li class="sidebar-nav__item--credit">
        <span class="sidebar-nav__item-note">A franchise of</span>
        <a href="https://larp.ca"><img src="{$assets_dir}img/logo--black.png" alt="Underworld LARP"></a>
    </li>
</ul>

{foreach from=$main_menu item=item}
    {if $item->children}
        <div class="sidebar-nav__pane--nav" data-sidebar-pane="pane-{$item->ID}">
            <ul class="sidebar-nav__pane-nav--level-1">
                {foreach from=$item->children item=level_1_item}
                    <li class="sidebar-nav__pane-nav-item">
                        <a
                            {if $level_1_item->children}href="#"{else}href="{$level_1_item->url}"{/if}
                            class="sidebar-nav__pane-nav-item-link"
                            {if $level_1_item->children}data-sidebar-level="level-2-{$level_1_item->ID}"{/if}
                        >
                            {$level_1_item->title}
                        </a>
                    </li>
                {/foreach}
            </ul>

            {foreach from=$item->children item=level_1_item}
                {if $level_1_item->children}
                    <ul class="sidebar-nav__pane-nav--level-2" data-sidebar-level="level-2-{$level_1_item->ID}">
                        {foreach from=$level_1_item->children item=level_2_item}
                            <li class="sidebar-nav__pane-nav-item">
                                <a
                                    {if $level_2_item->children}href="#"{else}href="{$level_2_item->url}"{/if}
                                    class="sidebar-nav__pane-nav-item-link"
                                    {if $level_2_item->children}data-sidebar-level="level-3-{$level_1_item->ID}-{$level_2_item->ID}"{/if}
                                >
                                    {$level_2_item->title}
                                </a>
                            </li>
                        {/foreach}
                    </ul>

                    {foreach from=$level_1_item->children item=level_2_item}
                        {if $level_2_item->children}
                            <ul class="sidebar-nav__pane-nav--level-3" data-sidebar-level="level-3-{$level_1_item->ID}-{$level_2_item->ID}">
                                <li class="sidebar-nav__pane-nav-item">
                                    <a href="#" class="sidebar-nav__pane-nav-item-link back">Back</a>
                                </li>
                                {foreach from=$level_2_item->children item=level_3_item}
                                    <li class="sidebar-nav__pane-nav-item">
                                        <a href="{$level_3_item->url}" class="sidebar-nav__pane-nav-item-link">
                                            {$level_3_item->title}
                                        </a>
                                    </li>
                                {/foreach}
                            </ul>
                        {/if}
                    {/foreach}
                {/if}
            {/foreach}
        </div>
    {/if}
{/foreach}

<!-- Start .page-wrapper -->
<div class="page-wrapper">
