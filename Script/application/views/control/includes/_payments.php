<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?= get_form_response('form_response') ?>

<?php $base_url = base_url('control/payments') ?>

<?php if($payments): ?>

<script src="https://cdn.jsdelivr.net/npm/vue@2.6.11"></script>

<!-- summernote css/js -->
<link href="<?= base_url('assets/plugins/summernote-lite.css') ?>" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote-lite.min.js"></script>


<div class="items bottom content payments" id="payments">
	<table class="ui basic celled unstackable table">
		<thead>
			<tr>
				<th>Email</th>
				<th class="center aligned"><?= lang('ui_points') ?></th>
        <th class="center aligned"><?= lang('ui_author').' '.lang('ui_details') ?></th>
				<th class="center aligned">Teks</th>
        <th class="center aligned"><?= lang('ui_created_at') ?> <a href="<?= "$filters_base_url/created_at/order/$order" ?>"><i class="sort icon mr-0"></i></a></th>
				<th class="center aligned"><?= lang('ui_paid') ?></th>
			</tr>
		</thead>

		<tbody>
			<?php foreach($payments as $key => $payment): ?>
			<tr class="<?= $payment->paid ? 'paid' : '' ?> ">
				<td><?= $payment->user_email ?></td>
				<td class="center aligned"><?= $payment->points ?></td>
				<td class="center aligned"><button  @click="readPayment(<?= $key ?>)" class="ui yellow mini button" type="button"><?= lang('ui_read') ?></button></td>
				<td class="center aligned"><button class="ui mini blue button" type="button"
						@click="messageAuthor('<?= $payment->user_email ?>')">Kirim</button></td>
				<td class="center aligned"><?= $payment->created_at ?></td>
				<td class="center aligned">
					<div class="ui <?= $payment->paid ? 'checked' : '' ?> fitted toggle checkbox">
						<input type="checkbox" value="<?= $payment->id ?>" class="hidden">
						<label></label>
					</div>
				</td>
			</tr>
			<?php endforeach ?>
		</tbody>

		<tfoot>
			<tr>
				<th colspan="8">
					<?= get_html_pagination($pagination) ?>
				</th>
			</tr>
		</tfoot>
	</table>

	<div class="ui modal payments">
		<div class="header"><?= lang('ui_author').' '.lang('ui_details') ?></div>
		<div class="content">
			<table class="ui table celled unstackable padded">
				<tbody>
					<tr>
						<th>Nama Depan</th>
						<td>{{ payment.user_firstname }}</td>
					</tr>
					<tr>
						<th>Nama Belakang</th>
						<td>{{ payment.user_lastname }}</td>
					</tr>
					<tr>
						<th>Nomor Telp</th>
						<td>{{ payment.user_phone_number }}</td>
					</tr>
					<tr>
						<th>Nama bank</th>
						<td>{{ payment.user_bank_name }}</td>
					</tr>
					<tr>
						<th>Nomor Rekening Bank</th>
						<td>{{ payment.user_bank_account_number }}</td>
					</tr>
					<tr>
						<th>ID KTP Depan</th>
						<td>
							<img v-if="payment.user_card_id_1" :src="'//uploads/ids/' + payment.user_card_id_1 + '?v=' + new Date().getTime()" alt="Card ID 1" class="ui rounded image">
							<div v-else class="ui fluid small negative  message">Belum diunggah!</div>
						</td>
					</tr>
					<tr>
						<th>ID KTP Belakang</th>
						<td>
							<img v-if="payment.user_card_id_2" :src="'//uploads/ids/' + payment.user_card_id_2 + '?v=' + new Date().getTime()" alt="Card ID 2" class="ui rounded image">
							<div v-else class="ui fluid small negative  message">Belum diunggah!</div>
						</td>
					</tr>
					<tr>
						<th>Tanggal</th>
						<td>{{ payment.created_at }}</td>
					</tr>
					<tr class="main">
						<th>Poin ke Pertukaran</th>
						<td>{{ payment.points_to_exchange }} poin</td>
					</tr>
					<tr>
						<th>Email</th>
						<td>{{ payment.user_email }}</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="actions">
			<div class="ui cancel yellow button">Tutup</div>
		</div>
	</div>

	
	<div class="ui form modal author-message">
		<div class="header"><?= lang('ui_message_author') ?></div>
		<div class="content p-3">
			<input type="hidden" v-model="authorEmail">

			<div class="field">
				<label>Subjek</label>
				<input type="text" v-model="subject">
			</div>
			<div class="field">
				<label>Pesan</label>
				<textarea cols="30" rows="10" id="message-body" class="summernote"></textarea>
			</div>
		</div>
		<div class="actions">
			<div class="ui cancel yellow button">Tutup</div>
			<button class="ui red button send" @click="sendMessage($event)">Kirim</button>
		</div>
	</div>

</div>

<script type="application/javascript">
var app = new Vue({
	el: "#payments",
	data: {
		payments: <?=  json_encode($payments ?? []) ?>,
		payment: {},
		authorEmail: '',
		subject: '',
		message: '',
		exchangeRate: '<?= $this->settings['exchange_rate'] ?? 0 ?>',
	},
	methods: {
		readPayment: function(key)
		{
			this.payment = this.payments[key];

			$('.ui.payments.modal').modal({
				closable: false,
				centered: true,
				onVisible: function()
				{
					$('.payments.modal img').on('click', function()
					{
						window.open($(this)[0].src + '?v=' + new Date().getTime(), "_blank", "width=auto,height=50%")
					})
				}
			})
			.modal('show');
		},
		messageAuthor: function(email, username)
		{
			this.authorEmail = email;

			$('.modal.author-message').modal({
				closable: false,
			}).modal('show')
		},
		sendMessage: function(e)
		{
			this.message = $('#message-body').val();
			
			if(/\S+@\S+\.\S+/i.test(this.authorEmail) && this.subject.trim().length && this.message.trim().length)
			{
				$(e.target).prop('disabled', true).addClass('loading')

				$.post('/message_author', {"contact-email": this.authorEmail, "contact-subject": this.subject, "contact-body": this.message})
				.done(function(res)
				{
					alert(res.response)
				})
				.always(function()
				{
					$(e.target).prop('disabled', false).removeClass('loading')
				})
			}
		}
	}
})

$(function()
{
	$('.summernote')
	.summernote({
		placeholder: 'ketik pesan Anda di sini...',
		tabsize: 2,
		height: 300
	})

	$('.ui.checkbox.checked').checkbox('check').checkbox('set disabled');

	$('.ui.checkbox:not(.checked)').checkbox({
		onChecked: function(el)
		{
			var _this = $(this);
			var id 		= $(this).val().trim();

			if(isNaN(id))
				return;
			
			var author = null;

			for(k in app.payments)
			{
				if(app.payments[k].id == id)
				{
					author = app.payments[k];
					break;
				}
			}

			if(author !== null)
			{
				var payment_msg = "<?= lang('ui_payment_sent') ?>".replace('[AMOUNT]', 'IDR '+parseFloat(app.exchangeRate)*author.points_to_exchange);

				var msgPayload = {"id": id, "points_to_exchange": author.points_to_exchange, "author_id": author.user_id,
													"contact-email": author.user_email, "contact-subject": "Payment", "contact-body": payment_msg};

				$.post('/mark_payment_as_paid', msgPayload)
				.done(function()
				{
					_this.closest('.checkbox').checkbox('set disabled').closest('tr').addClass('paid');
				})
			}
		}
	});
})
</script>

<?php else: ?>

<div class="ui fluid message">Tidak ada yang ditemukan</div>

<?php endif ?>