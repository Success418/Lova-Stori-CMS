<div class="ui tabular menu">
	<h4 class="active item">
		<?= lang('ui_comments') ?> 
	</h4>
</div>

<div class="ui comments">
    
    <?php
	    if($comments)
	    {
	        $comments_indexes = array_keys($comments);
	        $comments_indexes = array_chunk($comments_indexes, 2, TRUE);
	        $comments_indexes = array_map('max', $comments_indexes);
	    }
    ?>
    
	<?php foreach ($comments as $index => $comment): ?>

	<div class="comment" id="comment_<?= md5($comment->id) ?>">
		<?php if(!$comment->author_image): ?>
		<span class="avatar text">
			<?= substr($comment->author_name, 0, 2) ?>
		</span>
		<?php else: ?>
		<span class="avatar img">
			<img width="39" height="39" src="<?= base_url("uploads/profiles/{$comment->author_image}") ?>" alt="avatar">
		</span>
		<?php endif ?>
		<div class="content">
			<span class="author"><?= ucfirst($comment->author_name) ?></span> <i class="check circle icon" style="color:#E6005C"></i>
			<div class="metadata">
				<span class="date"><?= get_time_ago_in_words($comment->date) ?></span>
			</div>
			<div class="role mt-2">
				<span>[<?= ucfirst($comment->author_role) ?> - Netizen]</span> 
			</div>
			<div class="text">
				<?= nl2br($comment->body) ?>
			</div>
			<div class="actions">
				<a class="reply" data-id="<?= encrypt($comment->id) ?>"><?= lang('ui_reply') ?> </a>
			</div>
		</div>

		<?php if($comment->subcomments): ?>

		<div class="comments">

		<?php foreach($comment->subcomments as $subcomment): ?>
			<div class="comment" id="subcomment_<?= md5($subcomment->id) ?>">
				<?php if(!$subcomment->author_image): ?>
				<span class="avatar text">
					<?= substr($subcomment->author_name, 0, 2) ?>
				</span>
				<?php else: ?>
				<span class="avatar img">
					<img width="39" height="39" src="<?= base_url("uploads/profiles/{$subcomment->author_image}") ?>" alt="avatar">
				</span>
				<?php endif ?>
				<div class="content">
					<span class="author"><?= ucfirst($subcomment->author_name) ?> </span> <i class="check circle icon" style="color:#E6005C"></i> 
					<div class="metadata">
						<span class="date"><?= get_time_ago_in_words($subcomment->date) ?></span>
					</div>
					<div class="role mt-2">
						<span>[<?= ucfirst($subcomment->author_role) ?>]</span> 
					</div>
					<div class="text">
						<?= nl2br($subcomment->body) ?>
					</div>
					<div class="actions">
						<a class="reply" data-id="<?= encrypt($comment->id) ?>"><?= lang('ui_reply') ?> </a>
					</div>
				</div>
			</div>
		<?php endforeach ?>

		</div>
		
		<?php endif ?>

	</div>
    
    <?php if(in_array($index, $comments_indexes) && get_ad_units('link')): ?>
    <div class="comment">
        <?= get_ad_units('link') ?>
    </div>
    <?php endif ?>
    
	<?php endforeach ?>

</div>