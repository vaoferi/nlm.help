<?php

/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

/* @var $this \yii\web\View */
/* @var $contactForm  \frontend\models\ContactForm */
/* @var $models array|\common\models\HelpCenter[]|\common\models\Partner[]|\yii\db\ActiveRecord[] */
$json = \common\models\HelpCenter::createJson($models);
$servicesString = Yii::t('frontend', 'Services:');
$contactsString = Yii::t('frontend', 'Contacts:');
$detailsString = Yii::t('frontend', 'details');
?>
    <section class="contact-page">
        <div class="news-page__filter">
            <div class="news-page__filter-top">
                <div class="news-page__filter-item">
                    <div class="input-wrap input-wrap-select">
                        <?php  $city = \common\models\HelpCenter::getPlaceNames(); ?>
                        <select class="select-country--js">
                            <option value="All"><?= Yii::t('frontend', 'All') ?></option>
                        <?php   foreach ($city as $key => $item){ ?>
                            <option value="<?= $key ?>"><?= $item ?></option>
                        <?php } ?>
                        </select>
                    </div>
                </div>
<!--                <div class="news-page__filter-item">-->
<!--                    <div class="input-wrap">-->
<!--                        <input data-filter="clothes" class="checkbox-service--js" name="contact-filter"-->
<!--                               id="clothes-contacts" type="checkbox" checked>-->
<!--                        <label for="clothes-contacts">Clothes</label>-->
<!--                    </div>-->
<!--                </div>-->
                <div class="news-page__filter-item">
                    <div class="input-wrap">
                        <input data-filter="medicine" class="checkbox-service--js" name="contact-filter"
                               id="medicine-contacts" type="checkbox" checked>
                        <label for="medicine-contacts"><?= Yii::t('common', 'Medicine') ?></label>
                    </div>
                </div>
                <div class="news-page__filter-item">
                    <div class="input-wrap">
                        <input data-filter="shelter" class="checkbox-service--js" name="contact-filter"
                               id="shelter-contacts" type="checkbox" checked>
                        <label for="shelter-contacts"><?= Yii::t('common', 'Shelter') ?></label>
                    </div>
                </div>
                <div class="news-page__filter-item">
                    <div class="input-wrap">
                        <input data-filter="food" class="checkbox-service--js" name="contact-filter" id="food-contacts"
                               type="checkbox" checked>
                        <label for="food-contacts"><?= Yii::t('common', 'Food') ?></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="contact-page__slider-wrap">
            <div class="contact-page__slider">
            </div>
        </div>
        <div class="contact-page__map-wrap">
            <div class="contact-page__map">
                <img src="/img/general/contact-map-2.png">
            </div>
            <div class="contact-page__map-mark" data-country="kyiv" data-country-name="<?= Yii::t('common', 'Kyiv') ?>" data-top="430" data-left="627"></div>
            <div class="contact-page__map-mark" data-country="dnipro" data-country-name="<?= Yii::t('common', 'Dnipro') ?>" data-top="890" data-left="950"></div>
            <div class="contact-page__map-mark" data-country="izmail" data-country-name="<?= Yii::t('common', 'Izmail') ?>" data-top="1590" data-left="500"></div>
            <div class="contact-page__map-mark" data-country="tarutino" data-country-name="<?= Yii::t('common', 'Tarutino') ?>" data-top="1400" data-left="530"></div>
            <div class="contact-page__map-mark contact-page__map-mark--bottom" data-country="artsyz" data-country-name="<?= Yii::t('common', 'Artsyz') ?>" data-top="1440" data-left="550"></div>
            <div class="contact-page__map-mark contact-page__map-mark--bottom" data-country="berezino" data-country-name="<?= Yii::t('common', 'Berezino') ?>" data-top="1380" data-left="540"></div>
            <div class="contact-page__map-mark" data-country="zaporizhzhia" data-country-name="<?= Yii::t('common', 'Zaporizhzhia') ?>" data-top="1010" data-left="964"></div>
            <div class="contact-page__map-mark" data-country="cherkasy-zagorodyshshe" data-country-name="<?= Yii::t('common', 'Cherkasy (Zagorodyshshe)') ?>" data-top="654" data-left="767"></div>
            <div class="contact-page__map-mark contact-page__map-mark--left" data-country="cherkasy" data-country-name="<?= Yii::t('common', 'Cherkasy') ?>" data-top="686" data-left="742"></div>
            <div class="contact-page__map-mark" data-country="poltava" data-country-name="<?= Yii::t('common', 'Poltava') ?>" data-top="620" data-left="920"></div>
            <div class="contact-page__map-mark" data-country="vinnytsia" data-country-name="<?= Yii::t('common', 'Vinnytsia') ?>" data-top="620" data-left="480"></div>
            <div class="contact-page__map-mark contact-page__map-mark--bottom" data-country="cherkasy-staryi-kovrai"  data-country-name="<?= Yii::t('common', 'Cherkasy (Staryi Kovrai)') ?>" data-top="650" data-left="778"></div>
            <div class="contact-page__map-mark contact-page__map-mark--bottom" data-country="tatarbunary"  data-country-name="<?= Yii::t('common', 'Tatarbunary') ?>" data-top="1500" data-left="566"></div>
            <div class="contact-page__map-mark contact-page__map-mark--bottom" data-country="ordesa-velykyi-dalnyk"  data-country-name="<?= Yii::t('common', 'Odessa (Velykyi Dal\'nyk)') ?>" data-top="1358" data-left="620"></div>
            <div class="contact-page__map-mark" data-country="odessa-krasnosilka"  data-country-name="<?= Yii::t('common', 'Odessa (Krasnosilka)') ?>" data-top="1300" data-left="640"></div>
            <div class="contact-page__map-mark" data-country="odesa" data-country-name="<?= Yii::t('common', 'Odesa') ?>" data-top="1350" data-left="640"></div>
            <div class="contact-page__map-mark" data-country="pavlograd" data-country-name="<?= Yii::t('common', 'Pavlograd') ?>" data-top="855" data-left="1000"></div>
            <div class="contact-page__map-mark contact-page__map-mark--bottom" data-country="ochakov" data-country-name="<?= Yii::t('common', 'Ochakov') ?>" data-top="1310" data-left="710"></div>
        </div>
    </section>
    <div class="contact-popup-details-overlay">
        <div class="contact-popup-details">
            <button class="contact-popup-details__close" type="button"></button>
            <div class="contact-popup-details__img"></div>
            <h3 class="contact-popup-details__title">Glory center</h3>
            <h3 class="contact-popup-details__subtitle">Paris</h3>
            <div class="contact-popup-details__info">
                <div class="contact-popup-details__services">
                    <h4>Services:</h4>
                    <div class="contact-popup-details__services-list">
                        <span>Clothes,</span>
                    </div>
                </div>
                <div class="contact-popup-details__contacts">
                    <h4>Contacts:</h4>
                    <div class="contact-popup-details__contacts-list">
                        <p></p>
                    </div>
                </div>
            </div>
            <div class="contact-popup-details__desc" style="display: none">
                <p></p>
            </div>
            <div class="contact-popup-details__links" style="display: none">
                <div class="contact-popup-details__projects">
                    <h4>Projects:</h4>
                    <ul class="contact-popup-details__projects-list">
                    </ul>
                </div>
                <div class="contact-popup-details__news">
                    <h4>Related news:</h4>
                    <ul class="contact-popup-details__news-list">
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="contact-popup-details-overlay contact-popup-details-overlay--js">
        <div class="contact-popup-details">
            <button class="contact-popup-details__close contact-popup-details__close--js" type="button"></button>
            <button class="contact-popup-details__prev"></button>
            <button class="contact-popup-details__next"></button>
            <div class="contact-popup-details__img"></div>
            <h3 class="contact-popup-details__title">Glory center</h3>
            <h3 class="contact-popup-details__subtitle">Paris</h3>
            <div class="contact-popup-details__info">
                <div class="contact-popup-details__services">
                    <h4><?= $servicesString ?></h4>
                    <div class="contact-popup-details__services-list">
                        <span>Clothes,</span>
                    </div>
                </div>
                <div class="contact-popup-details__contacts">
                    <h4><?= $contactsString ?></h4>
                    <div class="contact-popup-details__contacts-list">
                        <p></p>
                    </div>
                </div>
            </div>
            <div class="contact-popup-details__desc" style="display: none;">
                <p></p>
            </div>
            <div class="contact-popup-details__links" style="display: none;">
                <div class="contact-popup-details__projects">
                    <h4>Projects:</h4>
                    <ul class="contact-popup-details__projects-list">
                    </ul>
                </div>
                <div class="contact-popup-details__news">
                    <h4>Related news:</h4>
                    <ul class="contact-popup-details__news-list">
                    </ul>
                </div>
            </div>
            <div>
                <button class="contact-page__item-contact-btn"><?= Yii::t('frontend', 'contact us') ?></button>
            </div>
        </div>
    </div>

    <div class="contact-popup-details-overlay contact-popup-contact-overlay--js">
        <?php \yii\widgets\ActiveForm::begin(); ?>
        <?= \yii\helpers\Html::activeHiddenInput($contactForm, 'help_center_id', [
            'class' => 'hidden-id'
        ]) ?>
        <div class="contact-popup-details contact-popup-contact">
            <button class="contact-popup-details__close contact-popup-contact__close--js" type="button"></button>
            <h3><?= Yii::t('frontend', 'Thank You for Your interest') ?></h3>
            <h4><?= Yii::t('frontend', 'To contact us please fill in the form below') ?></h4>
            <div class="contact-popup-contact__top">
                <div class="input-wrap">
                    <?= \yii\helpers\Html::activeTextInput($contactForm, 'full_name', [
                        'required' => 'required',
                        'placeholder' => $contactForm->getAttributeLabel('full_name')
                    ]) ?>
                </div>
                <div class="input-wrap">
                    <?= \yii\helpers\Html::activeTextInput($contactForm, 'phone', [
                        'placeholder' => $contactForm->getAttributeLabel('phone')
                    ]) ?>
                </div>
            </div>
            <div class="input-wrap">
                <?= \yii\helpers\Html::activeInput('email', $contactForm, 'email', [
                    'required' => 'required',
                    'placeholder' => $contactForm->getAttributeLabel('email')
                ]) ?>
            </div>
            <div class="input-wrap">
                <?= \yii\helpers\Html::activeTextarea($contactForm, 'body', [
                    'placeholder' => $contactForm->getAttributeLabel('body')
                ]) ?>
            </div>
            <div class="contact-popup-contact__top contact-popup-contact__top--captcha">
                <?= \yii\captcha\Captcha::widget([
                    'model' => $contactForm,
                    'attribute' => 'verifyCode',
                    'template' => '
                        <div class="input-wrap">    
                            {input}
                        </div>
                        <div class="input-wrap">
                            {image}
                        </div>
                    ',
                    'options' => [
                        'placeholder' => $contactForm->getAttributeLabel('verifyCode'),
                        'id' => 'contacts-captcha',
                        'required' => 'required',
                        'autocomplete' => 'off'
                    ]
                ]) ?>
            </div>
            <button class="contact-popup-details__btn"><?= Yii::t('frontend', 'Send') ?></button>
        </div>
        <?php \yii\widgets\ActiveForm::end(); ?>
    </div>
<?php

\common\widgets\Script::begin(); ?>
    <script>

        var contactSlider = $('.contact-page__slider');
        //contact page slider
        contactSlider.slick({
            dots: false,
            autoplay: true,
            autoplaySpeed: 8000,
            slidesToShow: 7,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 1920,
                    settings: {
                        slidesToShow: 6
                    }
                },
                {
                    breakpoint: 1600,
                    settings: {
                        slidesToShow: 5
                    }
                },
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 4
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        infinite: false,
                        autoplaySpeed: 800000
                    }
                }
            ]
        });

        var json = <?= $json ?>;
        for(var i=0; i<json.length; i++) {
            $('.select-country--js').find('option[value="'+ json[i].city_key +'"]').removeAttr('hidden');
        }

        function renderContactSlider(arrSlides) {
            for (var i = 0; i < arrSlides.length; i++) {
                contactSlider.slick('slickAdd', '<div class="All contact-page__item ' + arrSlides[i].city_key + ' ' + arrSlides[i].services.join(' ') + '">' +
                    '<div class="contact-page__img ' + arrSlides[i].city + '" style="background-image: url(' + arrSlides[i].thumbnail + ')"></div>' +
                    '<h2>' + arrSlides[i].name + '</h2>' +
                    '<h3>' + arrSlides[i].city + '</h3>' +
                    '<button class="contact-page__item-expand"></button>' +
                    '<div class="contact-page__item-details">' +
                    '<div class="contact-page__item-details-services">' +
                    '<div class="contact-page__item-details-services-left">' +
                    '<h4><?= $servicesString ?></h4>' +
                    '</div>' +
                    '<div class="contact-page__item-details-services-right">' +
                    '<span>' + arrSlides[i].servicesName.join(', <br>') + '</span>' +
                    '</div>' +
                    '</div>' +
                    '<div class="contact-page__item-details-contacts">' +
                    '<div class="contact-page__item-details-contacts-left">' +
                    '<h4><?= $contactsString ?></h4>' +
                    '</div>' +
                    '<div class="contact-page__item-details-contacts-right">' +
                    '<p>' + arrSlides[i].contacts + '</p>' +
                    '</div>' +
                    '</div>' +
                    '<button data-id="' + arrSlides[i].id + '" class="contact-page__item-details-btn"><?= $detailsString ?></button>' +
                    '</div>' +
                    '</div>');
            }
        }
        renderContactSlider(json);

        var btnOpenPopupContactDetails = $('.contact-page__item-details-btn');
        var btnClosePopupContactDetails = $('.contact-popup-details__close--js');
        var popupContactDetails = $('.contact-popup-details-overlay--js');

        var btnNextPopupContactDetails = $('.contact-popup-details__next');
        var btnPrevPopupContactDetails = $('.contact-popup-details__prev');

        //btn show next contact popup details
        var slickIndex;
        btnNextPopupContactDetails.on('click', function() {
            btnPrevPopupContactDetails.css({"visibility": "visible"});
            $('.contact-popup-details__prev').css({"visibility": "visible"});
            var parentItem = $(".contact-page__item[data-slick-index='" + slickIndex +"']");
            parentItem.next().find('.contact-page__item-details-btn').click();
            if(parentItem.next().next().length === 0) {
                btnNextPopupContactDetails.css({"visibility": "hidden"});
            }
        });

        //btn show prev contact popup details
        btnPrevPopupContactDetails.on('click', function() {
            btnNextPopupContactDetails.css({"visibility": "visible"});
            var parentItem = $(".contact-page__item[data-slick-index='" + slickIndex +"']");
            parentItem.prev().find('.contact-page__item-details-btn').click();
            if(parentItem.prev().prev().length === 0) {
                btnPrevPopupContactDetails.css({"visibility": "hidden"});
            }
        });

        //btn close contact popup details
        btnClosePopupContactDetails.click(function (e) {
            e.stopPropagation();
            popupContactDetails.removeClass('show');
            $('body').removeClass('no-scroll');
        });

        var btnExpand = $('.contact-page__item-expand');
        $('.contact-page').on('click', '.contact-page__item-expand', function () {
            $(this).next().slideToggle();
            $(this).toggleClass('active');
        });

        var popupContactImg = $('.contact-popup-details__img');
        var popupTitle = $('.contact-popup-details__title');
        var popupSubtitle = $('.contact-popup-details__subtitle');
        var popupDesc = $('.contact-popup-details__desc p');
        var popupContacts = $('.contact-popup-details__info p');
        var popupServices = $('.contact-popup-details__services-list span');
        var popupNews = $('.contact-popup-details__news-list');
        var popupProjects = $('.contact-popup-details__projects-list');
        //btn open contact popup details
        $('.contact-page').on('click', '.contact-page__item-details-btn', function (e) {
            e.stopPropagation();
            $('body').addClass('no-scroll');
            popupContactDetails.addClass('show');
            var id = $(this).attr('data-id');
            $('.hidden-id').val(id);
            var item = json.find(function (x) {
                return x.id === +id;
            });
            popupContactImg.css("background-image", "url(" + item.thumbnail + ")");
            popupTitle.html(item.name);
            popupSubtitle.html(item.city);
            popupDesc.html(item.description);
            popupContacts.html(item.contacts);
            popupServices.html($.grep(item.servicesName, Boolean).join(', <br>'));
            for (var i = 0; i < item.news.length; i++) {
                var itemNew = '<li><a href="' + item.news[i].url + '" title="' + item.news[i].title + '" target="_blank">' + item.news[i].title + '</a></li>';
                popupNews.append(itemNew);
            }
            for (var j = 0; j < item.projects.length; j++) {
                var itemProject = '<li><a href="' + item.projects[j].url + '" title="' + item.projects[j].title + '" target="_blank">' + item.projects[j].title + '</a></li>';
                popupProjects.append(itemProject);
            }

            slickIndex = $(this).closest('.contact-page__item').attr('data-slick-index');

            var parentItem = $(".contact-page__item[data-slick-index='" + slickIndex +"']");
            if(parentItem.next().length === 0) {
                btnNextPopupContactDetails.css({"visibility": "hidden"});
            } else {
                btnNextPopupContactDetails.css({"visibility": "visible"});
            }

            if(parentItem.prev().length === 0) {
                btnPrevPopupContactDetails.css({"visibility": "hidden"});
            } else {
                btnPrevPopupContactDetails.css({"visibility": "visible"});
            }
        });

        var contactCheckboxes = $('.checkbox-service--js');
        var selectCountry = $('.select-country--js');
        var filtered = false;
        var markMap = $('.contact-page__map-mark');

        var serviceFilter;
        var countryFilter;
        var filter;

        function filterSlider(filter) {
            var fCountry = countryFilter ? '.' + countryFilter : '.All';
            var filt;
            if (!filter || filter.length === 0) {
                filt = fCountry;
            } else {
                filt = filter.map(function (item) {
                    return fCountry + '.' + item;
                }).join(', ');
            }
            contactSlider.slick('slickUnfilter');
            contactSlider.slick('slickFilter', filt);
        }

        markMap.on('click', function () {
            countryFilter = $(this).attr('data-country').replace(/\s/g, '').replace(/[{()}]/g, '');
            selectCountry.find('option:selected').removeProp("selected");
            selectCountry.find('option[value="'+ countryFilter +'"]').prop('selected', true);
            filterSlider(filter);

            var sliders = $('.contact-page__item');
            if(sliders.length !== 0) {
                sliders.eq(0).find('.contact-page__item-details-btn').click();
            }
        });

        selectCountry.on('change', function () {
            countryFilter = $(this).val().replace(/\s/g, '').replace(/[{()}]/g, '');
            filterSlider(filter);
        });

        contactCheckboxes.on('click', function () {
            filter = [];
            for (var i = 0; i < contactCheckboxes.length; i++) {
                if (contactCheckboxes.eq(i).prop('checked')) {
                    filter.push(contactCheckboxes.eq(i).attr('data-filter'));
                }
            }
            filterSlider(filter);
        });

        var contactUsBtn = $('.contact-page__item-contact-btn');
        var contactUsPopup = $('.contact-popup-contact-overlay--js');
        var contactUsClosePopup = $('.contact-popup-contact__close--js');
        contactUsBtn.click(function () {
            contactUsPopup.addClass('show');
        });

        contactUsClosePopup.click(function () {
            contactUsPopup.removeClass('show');
        })
    </script>
<?php \common\widgets\Script::end(); ?>