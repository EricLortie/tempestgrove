<!-- Landing Banner -->
<section class="sub">
  {if $alerts}
    <div class="alert">
    	{foreach from=$alerts item=$alert}
          {if $alert->fields['link_url']}
            <h4><a href="{$alert->fields['link_url']}"><i class="fas fa-exclamation-triangle"></i> <i class="fas fa-link"></i> {$alert->post_title}</a></h4>
          {else}
            <h4><i class="fas fa-exclamation-triangle"></i> {$alert->post_title}</h4>
          {/if}
      {/foreach}
    </div>
  {/if}
    <div class="container--xl text-center header-section">
        <a href="/" class="landing-banner__logo-link">
            <img src="{$assets_dir}img/logo--black.png" alt="" class="landing-banner__logo">
        </a>
        <h1 class="landing-banner__title has_particles">
            <span id="particles-js"></span>
            {if $title}
              <span class="title_text">{$title}<span>
            {else}
              <span class="title_text">{$post->post_title}<span>
            {/if}
        </h1>
    </div>
</section>