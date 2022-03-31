<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <?php $this->load->view('templates/opoin/partials/_head'); ?>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/slick-carousel/slick.min.css') ?>"/>
    <script type="text/javascript" src="<?= base_url('assets/plugins/slick-carousel/slick.min.js') ?>"></script>

<script src="https://cdn.jsdelivr.net/npm/vue@2.6.11"></script>


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

            <div class="page contributor-form">
                                          
              <div class="content">
              
                <form action="<?= base_url('/advertiser/advertise') ?>" method="post" enctype="multipart/form-data" class="ui form error success" id="advertise">
                  <input type="hidden" name="csrf_token" value="<?= get_csrf_token() ?>">

                  <div class="ui fluid card mt-0">
                    <div class="content header">
                      <h1>PASANG IKLAN'MU</h1>
                    </div>
                    <div class="content">

                      <?= get_form_response('form_response') ?>
                      
                      <div class="field">
                        <label>POSISI IKLAN BANNER <i class="exclamation link icon ml-3 mr-0"></i></label>
                        <div class="ui dropdown selection" id="ad_ref" required>
                          <input type="hidden" name="ad_ref" value="<?= session_get('old.ad_ref', '') ?>">
                          <i class="dropdown icon"></i>
                          <div class="default text" style="color: #000; text-transform: uppercase;">Pilih jenis iklan</div>
                          <div class="menu">
                            <?php foreach ($refs as $ref): ?>
                            <a class="item" data-price="<?= $ref->price ?>" data-item="<?= $ref->ref ?>"><?= $ref->ref ?></a>
                            <?php endforeach ?>
                          </div>
                        </div>
                      </div>

                      <div class="two fields">
                        <div class="field">
                          <label>NAMA IKLAN</label>
                          <input type="text" name="ad_name" value="<?= session_get('old.ad_name', '') ?>" placeholder="..." required>
                        </div>
                        <div class="field">
                          <label>UNGGAH BANNER KAMU</label>
                          <button class="ui pink fluid button" type="button" onclick="this.nextElementSibling.click()">UPLOAD</button>
                          <input class="d-none" type="file" name="ad_banner" accept=".jpg,.png,.jpeg" required>
                        </div>
                      </div>

                      <div class="field">
                        <label>TAMBAHKAN URL</label>
                        <input type="url" name="ad_url" value="<?= session_get('old.ad_url', '') ?>" placeholder="..." required>
                      </div>

                      <div class="grouped fields">
                        <label>ANGGARAN DANA</label>
                        <div class="field">
                          <div class="ui radio checkbox">
                            <input type="radio" name="ad_budget" value="2000000">
                            <label>IDR 2.000.000</label>
                          </div>
                        </div>
                        <div class="field">
                          <div class="ui radio checkbox">
                            <input type="radio" name="ad_budget" value="1500000">
                            <label>IDR 1.500.000</label>
                          </div>
                        </div>
                        <div class="field">
                          <div class="ui radio checkbox">
                            <input type="radio" name="ad_budget" value="1000000">
                            <label>IDR 1.000.000</label>
                          </div>
                        </div>
                        <div class="field">
                          <div class="ui radio checkbox">
                            <input type="radio" name="ad_budget" value="500000">
                            <label>IDR 500.000</label>
                          </div>
                        </div>
                        <div class="field">
                          <div class="ui radio checkbox">
                            <input type="radio" name="ad_budget" value="50000">
                            <label>IDR 50.000</label>
                          </div>
                        </div>
                        <div class="field">
                          <input type="number" step="0.1" name="ad_custom_budget" v-model="customBudget" placeholder="Masukkan dana IDR (minimal 50.000)">
                        </div>
                      </div>

                      <div class="field">
                        <label>Total Penayangan</label>
                        <div class="ui large basic label mx-0">{{ totalAmount() }} kali tayang</div>
                      </div>
                    </div>

                    <div class="content">
                      <button type="submit" class="ui button purple"><?= lang('ui_submit') ?></button>
                      <a href="/advertiser" class="ui button yellow"><?= lang('ui_cancel') ?></a>
                    </div>
                  </div>
                  <center><b><span style="color: blue">KLIK</span> CARA DEPOSIT DAN <a href="/page/panduan-iklan" target="_blank"><span style="color: rgb(255, 0, 102);">PANDUAN BERIKLAN</span></a></b></center>
                </form>

              </div>

              <div class="ui huge popup banner p-1">
                <img src="/assets/images/banner_ref.jpg" style="height: auto; width: 100%; min-width: 300px;">
              </div>

              <script>
                var vApp = new Vue({
                  el: "#advertise",
                  data: 
                  {
                    refPrice: null,
                    budget: '<?= session_get('old.ad_budget', '0') ?>',
                    customBudget: '<?= session_get('old.ad_custom_budget', '') ?>',
                  },
                  methods: 
                  {
                    totalAmount: function()
                    {
                      if(this.refPrice !== null && this.refPrice > 0)
                      {
                        if(this.budget > 0)
                        {
                          return parseInt(this.budget / this.refPrice);
                        }
                        else if(this.customBudget > 0)
                        {
                          return parseInt(this.customBudget / this.refPrice);
                        }
                      }

                      return 0; 
                    }
                  }
                });

                $(function()
                {
                  $('#top-menu a.item.logout').attr('href', '/logout');
                    
                  $('#ad_category, #ad_ref').dropdown({action: "activate"});

                  $('#ad_ref').dropdown({
                    onChange: function(val, text, choice)
                    {
                      vApp.refPrice = parseFloat($(choice).data('price'));
                    }
                  });

                  $('.ui.radio.checkbox').checkbox()
                                         .checkbox({
                                            onChecked: function()
                                            {
                                               $('input[name="ad_custom_budget"]').val('');
                                              vApp.budget = parseFloat($(this).val());
                                            }
                                         });

                  $('.exclamation.icon').popup({popup: '.banner', on: 'click'});

                  $('input[name="ad_custom_budget"]').on('change', function()
                  {
                    vApp.budget = 0;
                    $('.ui.checkbox').checkbox('uncheck');

                    if($(this).val() > 0 && $(this).val() < 50000)
                    {
                      vApp.customBudget = 50000;
                    }
                  })
                })
              </script>
            </div>

            <div class="footer">
              <?php $this->load->view('templates/opoin/partials/_footer'); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    
    

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