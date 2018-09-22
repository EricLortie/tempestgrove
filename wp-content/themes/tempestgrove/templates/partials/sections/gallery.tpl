<div id="block-{$block_id}">
	<div class="page-section__title-wrapper text-center">
		{if $gallery.title}<h2 class="page-section__title">{$gallery.title}</h2>{/if}
		{if $gallery.content}<p class="page-section__title-content">{$gallery.content}</p>{/if}
	</div>

	{if $gallery.gallery}
		<ul class="gallery" data-gallery="gallery-{$block_id}">
			{foreach from=$gallery.gallery item=photo}
				<li class="gallery__item">
				    <a href="#" class="gallery__item-link" data-gallery="gallery-{$block_id}">
				    	<img data-src="{$photo.sizes.200x150}" alt="{$photo.title}" class="gallery__item-image--thumbnail">
				    </a>
				</li>
			{/foreach}
		</ul>

		<!-- Gallery (Full) -->
		<div class="gallery--full" id="gallery-{$block_id}">
		    <!-- Close Icon -->
		    <a href="#" class="gallery__close-button">
		        <svg viewBox="0 0 24 24" class="core-icon--close">
		            <use xlink:href="#core-icon--close"></use>
		        </svg>
		    </a>
		    <!-- Slides -->
		    <div class="gallery__slides">
		    	{foreach from=$gallery.gallery item=photo}
		    		<div class="gallery__slide">
		    		    <img data-lazy="{$photo.sizes.large}" alt="{$photo.title}" class="gallery__item-image--full">
		    		    {if $photo.caption}<p class="gallery__slide-caption">{$photo.caption}</p>{/if}
		    		</div>
		    	{/foreach}
		    </div>
		</div>
	{/if}
</div>
