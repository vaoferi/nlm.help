<?php

/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

use common\models\UserSocialNetwork;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $users \common\models\User[] */
/* @var $currentLanguage  */
$this->params['custom_header'] = [
    'class' => 'albulm-hero about-us-hero',
    'content' => $this->render('_header_slider_about')
];


?>
<article class="news-one-info about-page-info">
    <h1>ÜBER UNS</h1>
<!-- test de -->
    <p>Die christliche Mission "Neues Leben" bringt Menschen zusammen, die Gott lieben und Menschen dienen. Die Aktivitäten der Organisation zielen darauf ab, Bedürftigen zu helfen - jenen, die sich in einer schwierigen Lebenssituation befinden. Die Mission besteht in der Ukraine seit 2010. Wir können Ihnen helfen, zu überleben, die Hungrigen zu ernähren, Haus der Barmherzigkeit, Heizpunkte.Im Rahmen dieser Projekte schafft die Organisation Sammel- und Ausgabestellen für humanitäre Hilfe, Heizpunkte für Obdachlose, eröffnet soziale Anpassungs- und Rehabilitationszentren, verteilt Nahrungsmittel an die Armen, hilft bei der medizinischen Versorgung usw.</p>
<p>Die Mission nahm ihre Arbeit in der Stadt Odessa auf. Für heute hat sich die Tätigkeit der Organisation auf das Territorium der gesamten Ukraine ausgedehnt. In 7 Jahren Arbeit wurden 8 Zweigstellen in verschiedenen Siedlungen des Landes geschaffen. Noch mehr Menschen wurden Freiwillige und Partner der Mission unter den Freiwilligen von 5 bis 60 Personen in jedem Zweig. "Neues Leben" arbeitet mit dem internationalen Verband YMCA, Emmanuel Internationaler Barmherzigkeitsdienst (IMOCE), Globaler christlicher Hilfsdienst (GCS).</p>
<p>Mit der Unterstützung dieser Missionen ist es möglich geworden, mehr Ukrainer mit Sorgfalt und Aufmerksamkeit zu erreichen. Jeden Tag wenden sich Menschen - ob obdachlose, mitarbeitende, sozial ungeschützte Bevölkerungsgruppen oder einfach diejenigen, die zu Geiseln der Umstände geworden sind - mit ihren Problemen an die Organisation.Dank ihrer Reaktionsfähigkeit und Hilfsbereitschaft finden sie hier Lösungen für ihre Probleme und gewinnen Hoffnung, und einige beginnen ein neues Leben. Schließlich besteht das Hauptziel der Mission nicht nur darin, einmalige Hilfe zu leisten, sondern denjenigen, die es wirklich wollen, zu helfen, aus dem Teufelskreis auszubrechen und zu vollwertigen Persönlichkeiten zu werden. Die christliche Mission "Neues Leben" unter dem Motto "Wir lieben Gott - diene den Menschen!" entwickelt sich weiter und gewinnt neue Dimensionen, indem sie all jene zusammenbringt, denen die Probleme anderer nicht gleichgültig sind und die bereit sind, dem Nächsten nicht mit Worten, sondern mit Taten zu helfen.
</p>

</article>

  <?php if ($users) : ?>
      <section class="container category-news">
             <div class="hero-quote our-team-title">
                 <?= Yii::t('frontend', 'Our Team') ?>
             </div>

          <div class="articles__wrap">
              <div class="articles__col articles__col--left category__wrap row">
                  <?php foreach ($users as $user) : ?>
                  <?php $photoSrc = Yii::$app->glide->createSignedUrl(['glide/index', 'path' => $user->photo_path], true); ?>
                      <div class="articles__item">
                          <div class="articles__item-img">
                              <img style="max-height: 460px" src="<?=$photoSrc?>">
                              <?= Html::a(Yii::t('frontend', 'More Details'),
                                  Url::to(['article/view-user', 'slug' => $user->slug]), [
                                      'class' => 'articles__item-link'
                              ])?>
                          </div>
                          <a href="<?= Url::to(['article/view-user', 'slug' => $user->slug]) ?>">
                              <?php if ($fullName = $user->getFullName($currentLanguage)): ?>
                                  <h3><?php echo Html::encode($fullName); ?></h3>
                              <?php endif; ?>

                              <?php if (!empty($position = $user->getPosition($currentLanguage))) : ?>
                                  <p><?= $position ?></p>
                              <?php endif ?>

                              <?php if (!empty($shortInfo = $user->getInfo($currentLanguage))) : ?>
                                  <p><?= $shortInfo ?></p>
                              <?php endif ?>
                          </a>

                            <?php if ($userSocialNetworks = $user->userSocialNetworks) : ?>
                                <div class="user__socials-wrap">
                                    <?php foreach ($user->userSocialNetworks as $userSocialNetwork): ?>
                                    <?php $network = UserSocialNetwork::getSocialNetworkTitle($userSocialNetwork->social_network); ?>
                                       <?= $this->render('_social_network_icons', [
                                               'network' => $network,
                                               'userSocialNetwork' => $userSocialNetwork
                                        ]); ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif ?>

                      </div>
                  <?php endforeach  ?>
              </div>
          </div>
      </section>
  <?php endif ?>





<section class="about-page-story">
    <div class="container">
        <h2>Geschichte der Mission</h2>
        <ul class="about-page-story__list">
            <li class="about-page-story__item">
                <span>2010</span>
                <ul class="about-page-story-inner__list">
                    <li class="about-page-story-inner__item">Der Beginn des Dienstes an den Obdachlosen Fjodor Gerasimow</li>
                    <li class="about-page-story-inner__item">Einführung des Gefängnisdienstes als Seelsorger</li>
                </ul>
            </li>
            <li class="about-page-story__item">
                <span>2011</span>
                <ul class="about-page-story-inner__list">
                    <li class="about-page-story-inner__item">Registrierung der christlichen Mission "Neues Leben</li>
                </ul>
            </li>
            <li class="about-page-story__item">
                <span>2013</span>
                <ul class="about-page-story-inner__list">
                    <li class="about-page-story-inner__item">Beginn einer produktiven Zusammenarbeit mit den Medien</li>
                </ul>
            </li>
            <li class="about-page-story__item">
                <span>2014</span>
                <ul class="about-page-story-inner__list">
                    <li class="about-page-story-inner__item">Produktive Zusammenarbeit mit den Behörden bei der Registrierung von Obdachlosen und Armen eingeleitet</li>
                    <li class="about-page-story-inner__item">Beginnen Sie als Freiwillige mit Heizstellen zu arbeiten</li>
                    <li class="about-page-story-inner__item">Im New Life Rehabilitation Center, in dem YMCA-Freiwillige arbeiten, wird der Dienst "Reise in die Freiheit" eröffnet.</li>
                    <li class="about-page-story-inner__item">Eröffnung einer Zweigstelle in Tscherkassy</li>
                </ul>
            </li>
            <li class="about-page-story__item">
                <span>2015</span>
                <ul class="about-page-story-inner__list">
                    <li class="about-page-story-inner__item">Eröffnung der zweiten Filiale in Tscherkassy</li>
                    <li class="about-page-story-inner__item">Die Organisation hat ihre Arbeit in den Strafkolonien Nr. 51 und Nr. 74 in Odessa aufgenommen, wo soziale und spirituelle Arbeit mit Häftlingen geleistet und humanitäre Hilfe geleistet wird.</li>
                    <li class="about-page-story-inner__item">Das Projekt "Lasst uns helfen zu überleben" ist angelaufen. Vertreter und Freiwillige des Projekts organisierten Sammel- und Lieferstellen für humanitäre Hilfe an sozial ungeschützte Bevölkerungsgruppen.</li>
                    <li class="about-page-story-inner__item">Im Rahmen des Projekts "Brot mit den Hungrigen teilen", die tägliche Verpflegung von Obdachlosen vor dem Bahnhof (Puschkin-Park).</li>
                </ul>
            </li>
            <li class="about-page-story__item">
                <span>2016</span>
                <ul class="about-page-story-inner__list">
                    <li class="about-page-story-inner__item">In Odessa wurden Heizpunkte für Obdachlose eingerichtet. Eine davon wurde im Primorski-Viertel am Starosnaja-Platz installiert. Der andere liegt im Suworowski-Viertel an der Julio-Curie. Die christliche Mission ist neues Leben, eingeladen als Organisatoren</li>
                    <li class="about-page-story-inner__item">Eröffnung einer Zweigstelle in Saporoschje.</li>
                </ul>
            </li>
            <li class="about-page-story__item">
                <span>2017</span>
                <ul class="about-page-story-inner__list">
                    <li class="about-page-story-inner__item">Eröffnung einer Unterkunft für ältere Menschen im Dorf Krasnoselka.</li>
                    <li class="about-page-story-inner__item">Das Rehabilitationszentrum "Neues Leben" wird in Veliky Dalnik PGT eröffnet.</li>
                    <li class="about-page-story-inner__item">Eröffnung einer Außenstelle der Mission in Saporoschje.</li>
                    <li class="about-page-story-inner__item">Baubeginn eines Altenpflegeheims in Lubny.</li>
                    <li class="about-page-story-inner__item">Eröffnung einer Außenstelle der Mission in Nikolaev für das Projekt "Lasst uns helfen zu überleben".</li>
                    <li class="about-page-story-inner__item">Eröffnung einer Außenstelle der Mission in Ochakov für das Projekt "Lasst uns helfen zu überleben".</li>
                </ul>
            </li>
            <li class="about-page-story__item">
                <span>2017</span>
                <ul class="about-page-story-inner__list">
                    <li class="about-page-story-inner__item">Eröffnung von Zweigstellen der Mission für das Projekt "Lasst uns helfen zu überleben" in folgenden Städten: Pawlograd, Poltawa, Kiew, Artsiz, Beresino, Kamenskoje, Dnipro, Ismail und Winniza.</li>
                    <li class="about-page-story-inner__item">Rehabilitationszentrum "Neues Leben" in Saporoschje</li>
                    <li class="about-page-story-inner__item">Registrierung der Internationalen Mission New Life</li>
                </ul>
            </li>
            <li class="about-page-story__item">
                <span>2019</span>
                <ul class="about-page-story-inner__list">
                    <li class="about-page-story-inner__item">Eröffnung des Projekts "New Life Creators" in Zusammenarbeit mit der Internationalen Mission "Neues Leben"</li>
                </ul>
            </li>
        </ul>
    </div>
</section>
<section class="news-one-slider-wrap about-page-diploma-slider-wrap">
    <div class="news-one-slider about-page-diploma-slider about-page-diploma-slider--js">
        <div class="news-one-slider-item">
            <img src="/img/content/about-diploma-slider-1.png">
        </div>
        <div class="news-one-slider-item">
            <img src="/img/content/about-diploma-slider-2.png">
        </div>
        <div class="news-one-slider-item">
            <img src="/img/content/about-diploma-slider-3.png">
        </div>
        <div class="news-one-slider-item">
            <img src="/img/content/about-diploma-slider-4.png">
        </div>
        <div class="news-one-slider-item">
            <img src="/img/content/about-diploma-slider-5.png">
        </div>
        <div class="news-one-slider-item">
            <img src="/img/content/about-diploma-slider-6.png">
        </div>
    </div>
</section>
