<!DOCTYPE html>
<html lang="en">
    

      <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">


	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <?php compileScss(); ?>


    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <link rel="alternate" href="<?= base_url() ?>" hreflang="en-us">
    <link rel="icon" href="<?=  base_url("assets/images/{$this->settings['site_favicon']}") ?>">
    <meta name="robots" content="noindex, nofollow">

    <title><?= lang('ui_post').' - '.lang('ui_add') ?></title>

    <!-- JQUERY -->
    <script rel="preload" src="<?= base_url("assets/libraries/jquery-3.3.1/jquery.min.js"); ?>"></script>

    <!-- JQUERY UI -->
    <script defer src="<?= base_url("assets/plugins/jquery-ui.min-1.12.0.js"); ?>"></script>

    <!-- SEMANTIC-UI -->
    <link rel="stylesheet" rel="preload" rel="import" href="<?= base_url("assets/frameworks/Semantic-UI-CSS-master/semantic.min.css"); ?>">
    <script defer src="<?= base_url("assets/frameworks/Semantic-UI-CSS-master/semantic.min.js"); ?>"></script>
    <link rel="stylesheet" rel="preload" rel="import" href="<?= base_url("assets/css/melovers.css"); ?>">    

    <!-- VUE.JS -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.11"></script>

    <!-- JS -->
    <script src="<?= base_url('assets/control/js/post.js?v=').time() ?>"></script>
    <script src="<?= base_url("assets/js/app.js") ?>"></script>


    <?php
      $style = get_cookie('style') 
          ?? $this->settings['site_style'] 
          ?? 'light';
    ?>

    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url("assets/css/opoin_{$style}.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/css/spacing.css") ?>">
    <link id="scrollbar" rel="stylesheet" href="<?= base_url("assets/css/scrollbar.css") ?>">

    <!-- summernote css/js -->
    <link href="<?= base_url('assets/plugins/summernote-lite.css') ?>" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote-lite.min.js"></script>
    
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/slick-carousel/slick.min.css') ?>"/>
    <script defer src="<?= base_url('assets/plugins/slick-carousel/slick.min.js') ?>"></script>

    <script>
      var categories 	  = <?= json_encode($categories, TRUE) ?>;
      var subcategories = <?= json_encode($subcategories_by_parent_id, TRUE) ?>;
    </script>
	</head>


	<body class="pushable">
		
		<div class="ui sidebar left" id="mobile-menu">
			<?php $this->load->view('templates/opoin/partials/_mobile_menu'); ?>
		</div>
		
		<div class="ui main container pusher" id="page">
			<div class="ui celled grid main m-0 shadowless">
				<div class="one column row content p-0">
					<div class="column" id="main-section">
						<div id="categories-menu">
						<?php $this->load->view('templates/opoin/partials/_categories_menu'); ?>
						</div>

						<div id="top-menu">
							<?php $this->load->view('templates/opoin/partials/_top_menu'); ?>
						</div>

						<div class="page" id="author-page">
						    




						    
												<?php if ($this->settings['site_important_note'] ?? null): ?>
						<div class="ui fluid segment" id="important-note">
							<i class="close icon link mx-0" onclick="$(this).parent().fadeOut()"></i>
							<h4><marquee scrolldelay="175" onmouseout="this.start()" onmouseover="this.stop()"><b><a href="/post/daftar-kontributor-panduan-penulis" target="Pinterest"><span style="color: #FFFF00;">LIHAT CARA PENARIKAN POIN</span></a></b> 1 HARI WAJIB 5 ARTIKEL ATAU KURANG (TIDAK BOLEH LEBIH) JIKA MELEBIHI DARI 5 ARTIKEL, JUMLAH POIN AKAN DIKURANGI OLEH SISTEM KAMI. TERIMA KASIH...</marquee></h4>
						</div>
						<?php endif ?>    
						    
						    
                                     
							<div class="ui raised center left aligned segment shadowless">
								<h2><?= lang('ui_post').' - '.lang('ui_add') ?></h2>
							</div>
              
							<div class="ui fluid divider"></div>
              
              <?= get_form_response('form_response') ?>

							<div class="content posts">
                <form action="/author/posts/store" class="ui fluid form" method="post" enctype="multipart/form-data">
                    <div class="field">
                      <label class="capitalize"><?= lang('ui_title') ?></label>
                      <input type="text" name="post_title" placeholder="WAJIB MENGGUNAKAN NAMA JUDUL YANG UNIK, JANGAN MENYAMAKAN NAMA JUDUL ARTIKEL YANG SUDAH ADA DI PENCARIAN GOOGLE" required value="<?= session_get('old_post.post_title') ?>">
                    </div>

                    <div class="field post_image">
                      <label><?= lang('ui_cover') ?></label>
                      <input type="file" name="post_image" required class="d-none" accept=".jpeg,.jpg,.ico,.png,.svg">
                      <div class="ui image rounded">
                        <img width="355" height="206" src="<?= base_url('uploads/images/default.jpg') ?>" alt="image">
                        <b>WAJIB! Ukuran Gambar 700X400</b>
                      </div>
                    </div>

                    <div class="field">
                      <label><?= lang('ui_summary') ?></label>
                      <textarea name="post_summary" cols="30" rows="5" placeholder="ISI DESKRIPSI MAKSIMAL 100 KATA"><?= session_get('old_post.post_summary') ?></textarea>
                    </div>

                    <div class="field">
                      <label><?= lang('ui_content') ?></label>  <br />
                      






                      
<style>
#informasi{
width:100%;
background: #fff;
color: #fff;
border: 2px solid purple;
padding: 10px;
text-align:center;
</style> 



<div class="ui fluid segment" id="important-note">
<i class="close icon link mx-0" onclick="$(this).parent().fadeOut()"></i> 

                      
                      
                      <b>HTML:</b>
<blockquote id="a"> <pre data-codetype="HTML">&lt;pre data-codetype=&quot;HTML&quot;&gt; ... &lt;/pre&gt;</pre></blockquote>



                       <b>CSS:</b>
<blockquote id="a"><pre data-codetype="CSS">&lt;pre data-codetype=&quot;CSS&quot;&gt; ... &lt;/pre&gt;</pre></blockquote>



                      <b>JAVASCRIPT:</b>
<blockquote id="a"><pre data-codetype="JavaScript">&lt;pre data-codetype=&quot;JavaScript&quot;&gt; ... &lt;/pre&gt;</pre></blockquote>




                     <b>JQUERY:</b>
<blockquote id="a"><pre data-codetype="JQuery">&lt;pre data-codetype=&quot;JQuery&quot;&gt; ... &lt;/pre&gt;</pre></blockquote>


                     <b>PHP:</b>
<blockquote id="a"><pre data-codetype="PHP">&lt;pre data-codetype=&quot;XML&quot;&gt; ... &lt;/pre&gt;</pre></blockquote>



                     <b>XML:</b>
<blockquote id="a"><pre data-codetype="XML"> &lt;pre data-codetype=&quot;XML&quot;&gt; ... &lt;/pre&gt; </pre></blockquote>



                      <b>QUOTES:</b>
<blockquote id="a"><blockquote id="a">&lt;blockquote id=&quot;a&quot;&gt;  ... TULISAN ARTIKELMU &lt;/blockquote&gt;</blockquote></blockquote>



                      <b>BLOCKQUOTE 1:</b>
<blockquote id="a"><blockquote id="d">&lt;blockquote id=&quot;d&quot;&gt;  ... TULISAN ARTIKELMU &lt;/blockquote&gt;</blockquote></blockquote>



                      <b>BLOCKQUOTE 2:</b><blockquote id="a"><div class="e"><div class="cool"><b>BACA</b></div>
&lt;div class=&quot;e&quot;&gt;
&lt;div class=&quot;cool&quot;&gt;
&lt;b&gt;BACA :&lt;/b&gt;&lt;/div&gt;
&lt;br /&gt;
        TULIS ARTIKELMU.
    &lt;/div&gt;
&lt;/div&gt; </blockquote>




                      <b>SPOILER:</b><blockquote id="a">
&lt;div class=&quot;mediaSpoiler&quot;&gt;
    &lt;div class=&quot;tombol&quot; tabindex=&quot;0&quot;&gt;&lt;/div&gt;
    &lt;div class=&quot;isi&quot;&gt;
        &lt;!-- Isi Spoiler --&gt;
        Tulis konten yang ingin disembunyikan disini.
    &lt;/div&gt;
&lt;/div&gt; </blockquote>







                      

<b>HARAP UNTUK DIBACA:</b>
<div class="mediaSpoiler"><div class="tombol" tabindex="0"></div><div class="isi">


<div class="e">
<div class="cool">
BACA :</div>
<br />
                     
<div class="peringatan"><b></b>-JANGAN ABAIKAN PESAN INI- PENTING UNTUK ANDA!!! SEBELUM AKUN ANDA TERKENA BANNED!!! *HARAP UNTUK TIDAK MELANGGAR ATURAN* (TANPA PEMBERITAHUAN TERLEBIH DULU)<br /> <br />  SELURUH TEAM AKAN MEMANTAU SETIAP ARTIKEL YANG ANDA BUAT. DIWAJIBKAN UNTUK MENAUTKAN LINK SETIAP KONTEN YANG ANDA BUAT. KONTEN TIDAK BOLEH 500 KARAKTER, KAMI MENYARAKAN KONTEN BERKUALITAS PANJANG KARAKTER RATA-RATA 1000 KATA ATAU LEBIH. BUKAN HANYA SEKEDAR ISI BAGIAN DARI KONTEN SAJA, TETAPI HARAP MEMBERIKAN INFORMASI SECARA RINCI DAN DETAIL, GAMBAR DAN VIDEO YOUTUBE.</b><br /> <br />DIHARAPKAN UNTUK SELALU MEMPERCANTIK SETIAP ARTIKEL YANG ANDA BUAT, HARAP MANAUTKAN BACKLINK DISETIAP ARTIKEL, AGAR SEO KONTEN DAPAT BERJALAN DIPENCARIAN UTAMA GOOGLE. BACKLINK YANG DISARANKAN, MINIMAL 3 LINK ATAU LEBIH. KARENA KAMI MENGUTAMAKAN KONTEN AGAR MUDAH DAN CEPAT TERINDEX DIHALAMAN UTAMA PENCARIAN GOOGLE.COM.<br /> <br /> UNTUK CONTOH BISA ANDA LIHAT DISINI: <a href="/panduan-artikel/contoh-1.jpg" target="_blank">CONTOH GAMBAR 1</a> DAN <a href="/panduan-artikel/contoh-2.jpg" target="_blank">CONTOH GAMBAR 2</a></span></div>                      
</div>



<div class="e">
<div class="cool">
PENTING :</div>
<br />
                     
<div class="peringatan">
    
    
<b><font size="2" color="000000"></font> <font size="2" color="FF0000">KONTRIBUTOR</font> <font size="2" color="FFEF00">TIDAK DAPAT MENGUNGGAH GAMBAR DISETIAP POSTINGAN <font size="2" color="ffffff">(</font>TERKECUALI COVER<font size="2" color="ffffff">)</font>.<br /> JIKA INGIN MENAMBAHKAN GAMBAR,  KAMU BISA MENGGUNAKAN LINK/URL GAMBAR</font> <font size="2" color="00D5FF"><br /><font size="2" color="ffffff">(</font>SETIAP GAMBAR DIWAJIBKAN UNTUK MENCANTUMKAN NAMA SUMBER LINK GAMBAR. CONTOH: SUMBER / ILUTRASI BY STORI.ID<font size="2" color="ffffff">)</font> - SARAN KAMI, UNGGAH GAMBAR DIHOSTING GRATIS, CONTOH: GOOGLE DRIVE / BLOGSPOT / WORDPRESS.</font> <font size="2" color="ffffff"><font size="2" color="000000">(</font>BUATLAH COVER SEMENARIK MUNGKIN, UNTUK MENARIK PAERHATIAN, SEHINGGA BERITA YANG KAMU BUAT DAPAT DIMINATI BANYAK PENGUNJUNG.</font><font size="2" color="000000">)</font><br /><br /> <font size="2" color="FFE600">AGAR MENARIK, BUATLAH TEKS <font size="2" color="cb0c4b">(</font>WATERMARK<font size="2" color="cb0c4b">)</font> NAMA KAMU DISETIAP GAMBAR, AGAR KARYAMU TIDAK DISALAHGUNAKAN <font size="2" color="cb0c4b">(</font>DIBAJAK<font size="2" color="cb0c4b">)</font> ORANG LAIN. BUATLAH KARYA TULISAN YANG BERKUALITAS AGAR KARYA TULISANMU DIHARGAI DAN DIMINATI BANYAK ORANG.</font><br /><br /><font size="2" color="A6FF00">UNTUK BERJAGA-JAGA, SEBELUM MENULIS DI FORM, HARAP UNTUK MENULISNYA TERLEBIH DULU DI WORD<br /> <font size="2" color="cb0c4b">(</font>LAPTOP/KOMPUTER<font size="2" color="cb0c4b">)</font> KAMU, KARENA SISTEM KAMI AKAN AUTO CLOSE KETIKA MEMBER HENDAK MEMPOSTING.</font><br /> <font size="2" color="00EBFF">DENGAN ALASAN: <font size="2" color="ffffff">(</font>KAMI MENGGUNAKAN TIMER AUTO CLOSE, SETIAP 5 MENIT SEKALI<font size="2" color="ffffff">)</font></font> </b>
    
</div>                      
</div>


<div class="e">
<div class="cool">
<b><font size="2" color="FFEF00">NOTED!</font> :</div>
<br />
                     
<div class="peringatan">
    
    
POIN ANDA AKAN KAMI POTONG SEMENTARA WAKTU, (SELAMA ANDA BELUM MEMPERBAIKI KONTEN YANG ANDA BUAT - JIKA SUDAH MEMPERBAIKINYA, HARAP MENGHUBUNGI ADMIN UNTUK MENGEMBALIKAN POIN SEMULA). SEMENTARA, JIKA TULISANMU TIDAK TERBIT DIBERANDA, ARTINYA TEAM KAMI TELAH MEMBATALKAN PENERBITAN ARTIKEL ANDA, DAN ANDA HARUS MEMPERBAIKI DAN MEMERIKSANYA KEMBALI KONTEN YANG ANDA BUAT.<br /> HARAP DIKETAHUI, TIDAK SEMUA SITUS PLATFORM MEDIA SAMA AKAN HAL DENGAN FITURNYA, INILAH ALASAN KAMI, AGAR ANDA UNTUK SELALU MEMERIKSA KONTEN ANDA KEMBALI SEBELUM ANDA TERBITKAN. KAMI MENEMUKAN BEBERAPA USER KETIKA UPLOAD, GAMBAR MENJADI BLANK ATAU DARI SISI TULISAN TERLALU OVER (BERLEBIHAN) SEHINGGA INI MENJADI ERROR PADA WEBSITE KAMI. DIWAJIBAKAN UNTUK TIDAK MENGUNGGAH GAMBAR, GUNAKAN URL GAMBAR DARI SUMBER YANG TERPERCAYA, KEMUDIAN TEMPELKAN DI FORM ARTIKEL KAMI.</b><br /><br /> <a href="/post/apa-perbedaannya-film-thriller-dan-horror" target="_blank">LIHAT CONTOH ARTIKEL INI: POSISI TATA LETAK GAMBAR DAN ISI TEKS YANG BAIK DAN BENAR, UNTUK GAMBAR,<br /> HARAP ISIKAN UKURAN GAMBAR MENJADI RESPONSIF 100% AGAR TERLIHAT RAPIH KONTEN YANG ANDA BUAT.</a>
    
</div>                      
</div>
</div>

</div></div>




                      <textarea name="post_body" cols="30" rows="15" class="summernote" required placeholder="----"> <b><span style="color: #ff004e;">Stori, Jakarta</span></b> <b>-&nbsp;</b> <?= session_get('old_post.post_body') ?>Ganti Nama Kotamu</textarea>
                    </div>

                    <div class="field">
                      <label><?= lang('ui_keywords') ?></label>
                      <input type="text" name="post_keywords" placeholder="UTAMAKAN KEYWORD ARTIKEL. CONTOH: Cara Merawat Kecantikan, Tips Mempercantik, dan seterusnya. Setiap keyword wajib pakai comma." value="<?= session_get('old_post.post_keywords') ?>">
                    </div>

                    <div class="field">
                      <label><?= lang('ui_category') ?></label>

                      <div class="ui search fluid selection dropdown post_category">
                        <input type="hidden" name="post_category" value="<?= session_get('old_post.post_category') ?>">
                        <i class="dropdown icon"></i>
                        <div class="default text"><?= lang('ui_select_category') ?></div>
                        <div class="menu">
                          <?php foreach($categories as $category): ?>
                            <div class="item" data-value="<?= $category['category_id'] ?>">
                              <?= $category['category_title'] ?>
                            </div>
                          <?php endforeach ?>
                        </div>
                      </div>

                      <input type="text" name="new_category" placeholder="<?= lang('ui_add_new_category') ?>" class="mt-1">
                    </div>

                    <div class="field">
                      <label><?= lang('ui_subcategory') ?></label>

                      <div class="ui search fluid selection dropdown post_subcategory">
                        <input type="hidden" name="post_subcategory" value="<?= session_get('old_post.post_subcategory') ?>">
                        <i class="dropdown icon"></i>
                        <div class="default text"><?= lang('ui_select_subcategory') ?></div>
                        <div class="menu"></div>
                      </div>

                      <input type="text" name="new_subcategory" placeholder="<?= lang('ui_add_new_subcategory') ?>" disabled class="mt-1">
                    </div>
                    
                    <div class="ui fluid divider"></div>

                    <div class="field">
                      <button class="ui yellow button" type="submit"><?= lang('ui_tayangkan') ?></button>
                      <a href="/author/posts" class="ui red button"><?= lang('ui_cancel') ?></a>
                    </div>
                </form>
              </div>
              
              <div class="ui modal post" style="max-width: 300px; width: 100%">
                <i class="close icon"></i>
                <div class="content"></div>	
              </div>
						</div>
            
						<div class="footer">
							<?php $this->load->view('templates/opoin/partials/_footer'); ?>
						</div>
					</div>
				</div>
			</div>
    </div>
    
    <script type="application/javascript">
      $(function()
      {
        $('#author-page form input').on("keydown", function(e)
        { 
            if(e.keyCode === 13)
            {
              e.preventDefault();
              return false;
            }
        });

        $('.summernote')
        .summernote({
          placeholder: '----',
          tabsize: 2,
          height: 300
        })

        $('.ui.dropdown.selection').dropdown({"action": "activate"});
        
        $('.post_category.dropdown').dropdown('set selected', '<?= $this->session->flashdata('post_category') ?>');
        $('.post_subcategory.dropdown').dropdown('set selected', '<?= $this->session->flashdata('post_subcategory') ?>');



        $('input[name="post_category"]').on('change', function()
        {
          $(this).closest('form').find('input[name="new_subcategory"]').prop('disabled', false)
        })



        // Add new subcategory
        $('input[name="new_subcategory"]').on('keydown', function(e)
        { 
          var val = $(this).val().trim();

          if(e.keyCode === 13 && val.length > 2)
          {
            var categoryId = parseInt($('input[name="post_category"]').val().trim());

            $.post('/author/add_subcategory', {categoryId: categoryId, title: val})
            .done(function(data)
            {
              if(data.res)
              {
                if(data.insertId)
                {
                  if(Object.keys(subcategories).indexOf(String(categoryId)) >= 0)
                  {
                    subcategories[categoryId].values.push({"value": data.insertId, "name": val});
                  }
                  else
                  {
                    subcategories[categoryId] = {"values": [{"value": data.insertId, "name": val}]};
                  }
                  
                  $('.post_subcategory')
                  .dropdown('restore defaults')
                  .dropdown('setup menu', subcategories[categoryId])
                  .dropdown('set selected', data.insertId);
                }
                else
                {
                  alert('<?= lang('ui_already_exists') ?>');
                }
              }
            })

            $(this).val('');
          }
        })

        

        // Add new category
        $('input[name="new_category"]').on('keydown', function(e)
        { 
          var _this = $(this);
          var val = $(this).val().trim();

          if(e.keyCode === 13 && val.length > 2)
          {
            $.post('/author/add_category', {title: val})
            .done(function(data)
            {
              if(data.res)
              {
                if(data.insertId)
                {
                  _this.siblings('.post_category')
                       .find('.menu')
                       .append('<div class="item" data-value="'+ data.insertId +'">'+ val +'</div>');
                  
                  $('.post_category')
                  .dropdown('refresh')
                  .dropdown('set selected', data.insertId);
                }
                else
                {
                  alert('<?= lang('ui_already_exists') ?>');
                }
              }
            })

            $(this).val('');
          }
        })


        
        $(".post_category").dropdown({onChange: (val)=>
          {
            $('.post_subcategory').dropdown('restore defaults')
                        .dropdown('setup menu', subcategories[val]
                                      ? subcategories[val]
                                      : {});
          }
        })


        $('#author-page form .post_image .image').on('click', function()
        {
          $(this).siblings('input').click();
        })

        $('.post_image input').on('change', function() {
          var file    = $(this)[0].files[0];
          var reader  = new FileReader();

          if(/^image\/(jpeg|jpg|ico|png|svg)$/.test(file.type))
          {
            reader.addEventListener("load", function() {
              $('#author-page form .post_image img').attr('src', reader.result);
            }, false);

            if(file)
              reader.readAsDataURL(file);
          }
          else
          {
            $('.modal.post').modal('show')
                    .modal('setting', 'duration', 0)
                    .find('.content').html('<h4>File yang dipilih tidak diizinkan</h4>\
                                <p>Ekstensi file harus berupa jpeg, jpg, png, ico atau svg</p>');

            $(this).val('');
          }
        })

        $('#top-menu a.item.logout').attr('href', '/logout');
      })
    </script>
    
    
    

<script type="text/javascript">
    function spoiler(obj){
    if (obj.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { obj.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = ''; obj.innerText = ''; obj.value = 'Sembunyikan'; }
    else { obj.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; obj.innerText = ''; obj.value = 'Tampilkan'; }}
</script>    
    


<script type="text/javascript">
    function spoilers(obj){
    if (obj.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { obj.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = ''; obj.innerText = ''; obj.value = 'Sembunyikan'; }
    else { obj.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; obj.innerText = ''; obj.value = 'BACA'; }}
</script>   
    




<script type="text/javascript">
function parseJSAtOnload() {
var links = ["assets/libraries/jquery-3.3.1/jquery.min.js", "assets/plugins/jquery-ui.min-1.12.0.js", "assets/frameworks/Semantic-UI-CSS-master/semantic.min.js", "assets/plugins/slick-carousel/slick.min.js"],
headElement = document.getElementsByTagName("head")[0],
linkElement, i;
for (i = 0; i < links.length; i++) {
linkElement = document.createElement("script");
linkElement.src = links[i];
headElement.appendChild(linkElement);
}
}
if (window.addEventListener)
window.addEventListener("load", parseJSAtOnload, false);
else if (window.attachEvent)
window.attachEvent("onload", parseJSAtOnload);
else window.onload = parseJSAtOnload;
</script>




    
	</body>

</html>