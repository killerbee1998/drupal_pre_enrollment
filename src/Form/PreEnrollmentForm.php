<?php

namespace Drupal\pre_enrollment\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\node\Entity\Node;
use \Exception;
use Drupal\Core\Url;
use Drupal\Core\Routing;

class PreEnrollmentForm extends FormBase {

  const pre_enrollment_PAGE = 'pre_enrollment_page:values';

  public function getFormId() {
    return 'pre_enrollment_page';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = array(
      '#attributes' => array('enctype' => 'multipart/form-data'),
    );

    $form['student_type'] = array(
      '#type' => 'radios',
      '#prefix' => '<h2 class="text-danger pb-3
      ">Alliance française Dhaka : Formulaire de Pré-inscription aux cours de Français Niveaux avancés | Pre-enrolment form for advanced French courses </h2> <br> <h3 class="pb-3"> Informations personnelles | Personal informations </h3>',
      // '#suffix' => '</div>',
      '#title' => ('Please select if you are a new or returning student'),
      '#options' => array(
        'New student' => $this->t('New student'),
        'Returning student' => $this->t('Returning student'),
      ),
      '#attributes' => [
        'name' => 'name_student_type',
      ]
    );


    $form['student_renewal'] = array(
      '#type' => 'textfield',
      '#prefix' => '<div class="form-group">',
      '#suffix' => '</div>',
      '#title' => $this->t('Membership Number: '),
      '#attributes' => [
        'id' => 'renewal_number',
      ],
      '#states' => [
        'visible' => [
          ':input[name="name_student_type"]' => ['value' => 'Returning student'],
        ]
      ],
    );


    $form['student_gender'] = array(
      '#type' => 'radios',
      '#prefix' => '<div class=" form-group">',
      '#suffix' => '</div>',
      '#title' => ('Sexe / Gender'),
      '#options' => array(
        'Female' => $this->t('Femme / Female'),
        'Male' => $this->t('Homme / Male'),
      ),
    );

    $form['student_fname'] = array(
      '#type' => 'textfield',
      '#prefix' => '<div class="form-group">',
      '#suffix' => '</div>',
      '#title' => $this->t('Prénom / First name '),

    );

    $form['student_lname'] = array(
      '#type' => 'textfield',
      '#prefix' => '<div class="form-group">',
      '#suffix' => '</div>',
      '#title' => $this->t('Nom / Last name '),

    );

    $form['student_telephone'] = array(
      '#type' => 'tel',
      '#prefix' => '<div class="form-group"> <p> Téléphone / Phone  </p>',
      '#suffix' => '</div>',
      '#title' => $this->t('+88'),
    );

    $form['student_email'] = array(
      '#type' => 'email',
      '#prefix' => '<div class="d-flex flex-column form-group"> <p> Courriel / Email </p>',
      '#suffix' => '</div>',
      '#title' => $this->t('Courriel / Email '),
      '#title_display' => 'invisible',

    );


    $form['student_dob'] = array(
      '#type' => 'date',
      '#prefix' => '<div class="form-group"> <p> Date de naissance / Date of the birth </p>',
      '#suffix' => '</div>',
      '#title' => $this->t('Date de naissance / Date of the birth'),

      '#title_display' => 'invisible',
    );

    $form['student_nidpassport'] = array(
      '#type' => 'textfield',
      '#name' => 'nidpassport',
      '#suffix' => '<br>',
      '#title' =>  $this->t('NID/Passport'),
      '#size' => 20,
      '#description' =>  $this->t('For adults only, please enter your NID or Passport number'),
    );

    $form['student_nationality'] = array(
      '#type' => 'select',
      '#title' => ('Nationalité | Nationality'),
      '#prefix' => '<div class=" py-2"> <p> Nationalité | Nationality </p>',
      '#suffix' => '</div>',
      '#title_display' => 'invisible',
      '#options' => array(
        "AFG" => $this->t('AFGHANE (AFG)'),
        "ALB" => $this->t('ALBANAISE (ALB)'),
        "DZA" => $this->t('ALGERIENNE (DZA)'),
        "DEU" => $this->t('ALLEMANDE (DEU)'),
        "USA" => $this->t('AMERICAINE (USA)'),
        "AND" => $this->t('ANDORRANE (AND)'),
        "AGO" => $this->t('ANGOLAISE (AGO)'),
        "ATG" => $this->t('ANTIGUAISE ET BARBUDIENNE (ATG)'),
        "ARG" => $this->t('ARGENTINE (ARG)'),
        "ARM" => $this->t('ARMENIENNE (ARM)'),
        "AUS" => $this->t('AUSTRALIENNE (AUS)'),
        "NFK" => $this->t('AUSTRALIENNE (NFK)'),
        "AUT" => $this->t('AUTRICHIENNE (AUT)'),
        "AZE" => $this->t('AZERBAÏDJANAISE (AZE)'),
        "BHS" => $this->t('BAHAMIENNE (BHS)'),
        "BHR" => $this->t('BAHREINIENNE (BHR)'),
        "BGD" => $this->t('BANGLADAISE (BGD)'),
        "BRB" => $this->t('BARBADIENNE (BRB)'),
        "BEL" => $this->t('BELGE (BEL)'),
        "BLZ" => $this->t('BELIZIENNE (BLZ)'),
        "BEN" => $this->t('BENINOISE (BEN)'),
        "BTN" => $this->t('BHOUTANAISE (BTN)'),
        "BLR" => $this->t('BIELORUSSE (BLR)'),
        "MMR" => $this->t('BIRMANE (MMR)'),
        "GNB" => $this->t('BISSAU-GUINEENNE (GNB)'),
        "BOL" => $this->t('BOLIVIENNE (BOL)'),
        "BES" => $this->t('BONAIRIENNE (BES)'),
        "BIH" => $this->t('BOSNIENNE (BIH)'),
        "BWA" => $this->t('BOTSWANEENNE (BWA)'),
        "BRA" => $this->t('BRESILIENNE (BRA)'),
        "GIB" => $this->t('BRITANNIQUE (GIB)'),
        "VGB" => $this->t('BRITANNIQUE (VGB)'),
        "MSR" => $this->t('BRITANNIQUE (MSR)'),
        "GBR" => $this->t('BRITANNIQUE (GBR)'),
        "SHN" => $this->t('BRITANNIQUE (SHN)'),
        "TCA" => $this->t('BRITANNIQUE (TCA)'),
        "JEY" => $this->t('BRITANNIQUE (JEY)'),
        "BRN" => $this->t('BRUNEIENNE (BRN)'),
        "BGR" => $this->t('BULGARE (BGR)'),
        "BFA" => $this->t('BURKINABE (BFA)'),
        "BDI" => $this->t('BURUNDAISE (BDI)'),
        "KHM" => $this->t('CAMBODGIENNE (KHM)'),
        "CMR" => $this->t('CAMEROUNAISE (CMR)'),
        "CAN" => $this->t('CANADIENNE (CAN)'),
        "CPV" => $this->t('CAP-VERDIENNE (CPV)'),
        "CHL" => $this->t('CHILIENNE (CHL)'),
        "CHN" => $this->t('CHINOISE (CHN)'),
        "TWN" => $this->t('CHINOISE (TAIWAN) (TWN)'),
        "CYP" => $this->t('CHYPRIOTE (CYP)'),
        "COL" => $this->t('COLOMBIENNE (COL)'),
        "COM" => $this->t('COMORIENNE (COM)'),
        "COG" => $this->t('CONGOLAISE (COG)'),
        "CRI" => $this->t('COSTARICAINE (CRI)'),
        "HRV" => $this->t('CROATE (HRV)'),
        "CUB" => $this->t('CUBAINE (CUB)'),
        "CUW" => $this->t('CURACIENNE (CUW)'),
        "DNK" => $this->t('DANOISE (DNK)'),
        "GRL" => $this->t('DANOISE (GRL)'),
        "DJI" => $this->t('DJIBOUTIENNE (DJI)'),
        "DMA" => $this->t('DOMINIQUAISE (DMA)'),
        "EGY" => $this->t('EGYPTIENNE (EGY)'),
        "ARE" => $this->t('EMIRIENNE (ARE)'),
        "GNQ" => $this->t('EQUATO-GUINEENNE (GNQ)'),
        "ECU" => $this->t('EQUATORIENNE (ECU)'),
        "ERI" => $this->t('ERYTHREENNE (ERI)'),
        "ESP" => $this->t('ESPAGNOLE (ESP)'),
        "TLS" => $this->t('EST-TIMORAISE (TLS)'),
        "EST" => $this->t('ESTONIENNE (EST)'),
        "ETH" => $this->t('ETHIOPIENNE (ETH)'),
        "FJI" => $this->t('FIDJIENNE (FJI)'),
        "FIN" => $this->t('FINLANDAISE (FIN)'),
        "FRA" => $this->t('FRANCAISE (FRA)'),
        "GLP" => $this->t('FRANCAISE (GLP)'),
        "GUF" => $this->t('FRANCAISE (GUF)'),
        "MTQ" => $this->t('FRANCAISE (MTQ)'),
        "MYT" => $this->t('FRANCAISE (MYT)'),
        "NCL" => $this->t('FRANCAISE (NCL)'),
        "PYF" => $this->t('FRANCAISE (PYF)'),
        "REU" => $this->t('FRANCAISE (REU)'),
        "SPM" => $this->t('FRANCAISE (SPM)'),
        "WLF" => $this->t('FRANCAISE (WLF)'),
        "BLM" => $this->t('FRANCAISE (BLM)'),
        "MAF" => $this->t('FRANCAISE (MAF)'),
        "GAB" => $this->t('GABONAISE (GAB)'),
        "GMB" => $this->t('GAMBIENNE (GMB)'),
        "GEO" => $this->t('GEORGIENNE (GEO)'),
        "GHA" => $this->t('GHANEENNE (GHA)'),
        "GRD" => $this->t('GRENADIENNE (GRD)'),
        "GTM" => $this->t('GUATEMALTEQUE (GTM)'),
        "GGY" => $this->t('GUERNESIAISE (GGY)'),
        "GIN" => $this->t('GUINEENNE (GIN)'),
        "GUY" => $this->t('GUYANIENNE (GUY)'),
        "HTI" => $this->t('HAÏTIENNE (HTI)'),
        "GRC" => $this->t('HELLENIQUE (GRC)'),
        "HND" => $this->t('HONDURIENNE (HND)'),
        "HUN" => $this->t('HONGROISE (HUN)'),
        "IND" => $this->t('INDIENNE (IND)'),
        "IDN" => $this->t('INDONESIENNE (IDN)'),
        "IRQ" => $this->t('IRAKIENNE (IRQ)'),
        "IRN" => $this->t('IRANIENNE (IRN)'),
        "IRL" => $this->t('IRLANDAISE (IRL)'),
        "ISL" => $this->t('ISLANDAISE (ISL)'),
        "ISR" => $this->t('ISRAËLIENNE (ISR)'),
        "ITA" => $this->t('ITALIENNE (ITA)'),
        "CIV" => $this->t('IVOIRIENNE (CIV)'),
        "JAM" => $this->t('JAMAÏCAINE (JAM)'),
        "JPN" => $this->t('JAPONAISE (JPN)'),
        "JOR" => $this->t('JORDANIENNE (JOR)'),
        "KAZ" => $this->t('KAZAKHSTANAISE (KAZ)'),
        "KEN" => $this->t('KENYANE (KEN)'),
        "KGZ" => $this->t('KIRGHIZE (KGZ)'),
        "KIR" => $this->t('KIRIBATIENNE (KIR)'),
        "KNA" => $this->t('KITTITIENNE-ET-NEVICIENNE (KNA)'),
        "KWT" => $this->t('KOWEÏTIENNE (KWT)'),
        "LAO" => $this->t('LAOTIENNE (LAO)'),
        "LSO" => $this->t('LESOTHANE (LSO)'),
        "LVA" => $this->t('LETTONE (LVA)'),
        "LBN" => $this->t('LIBANAISE (LBN)'),
        "LBR" => $this->t('LIBERIENNE (LBR)'),
        "LBY" => $this->t('LIBYENNE (LBY)'),
        "LIE" => $this->t('LIECHTENSTEINOISE (LIE)'),
        "LTU" => $this->t('LITUANIENNE (LTU)'),
        "LUX" => $this->t('LUXEMBOURGEOISE (LUX)'),
        "MKD" => $this->t('MACEDONIENNE (MKD)'),
        "MYS" => $this->t('MALAISIENNE (MYS)'),
        "ZXC" => $this->t('MALAISIENNE (autre) (ZXC)'),
        "MWI" => $this->t('MALAWIENNE (MWI)'),
        "MDG" => $this->t('MALGACHE (MDG)'),
        "MLI" => $this->t('MALIENNE (MLI)'),
        "MLT" => $this->t('MALTAISE (MLT)'),
        "IMN" => $this->t('MANNOISE (IMN)'),
        "MAR" => $this->t('MAROCAINE (MAR)'),
        "MUS" => $this->t('MAURICIENNE (MUS)'),
        "MRT" => $this->t('MAURITANIENNE (MRT)'),
        "MEX" => $this->t('MEXICAINE (MEX)'),
        "FSM" => $this->t('MICRONESIENNE (FSM)'),
        "MDA" => $this->t('MOLDAVE (MDA)'),
        "MCO" => $this->t('MONEGASQUE (MCO)'),
        "MNG" => $this->t('MONGOLE (MNG)'),
        "MNE" => $this->t('MONTENEGRINE (MNE)'),
        "MOZ" => $this->t('MOZAMBICAINE (MOZ)'),
        "NAM" => $this->t('NAMIBIENNE (NAM)'),
        "NRU" => $this->t('NAURUANE (NRU)'),
        "ANT" => $this->t('NEERLANDAISE (ANT)'),
        "ABW" => $this->t('NEERLANDAISE (ABW)'),
        "NLD" => $this->t('NEERLANDAISE (NLD)'),
        "SXM" => $this->t('NÉERLANDAISE (SXM)'),
        "NIU" => $this->t('NEO-ZELANDAISE (NIU)'),
        "NZL" => $this->t('NEO-ZELANDAISE (NZL)'),
        "TKL" => $this->t('NEO-ZELANDAISE (TKL)'),
        "NPL" => $this->t('NEPALAISE (NPL)'),
        "NIC" => $this->t('NICARAGUAYENNE (NIC)'),
        "NGA" => $this->t('NIGERIANE (NGA)'),
        "NER" => $this->t('NIGERIENNE (NER)'),
        "PRK" => $this->t('NORD-CORÉENNE (PRK)'),
        "NOR" => $this->t('NORVEGIENNE (NOR)'),
        "OMN" => $this->t('OMANAISE (OMN)'),
        "UGA" => $this->t('OUGANDAISE (UGA)'),
        "UZB" => $this->t('OUZBEKE (UZB)'),
        "PAK" => $this->t('PAKISTANAISE (PAK)'),
        "PLW" => $this->t('PALAU (PLW)'),
        "PSE" => $this->t('PALESTINIENNE (PSE)'),
        "PAN" => $this->t('PANAMEENNE (PAN)'),
        "PNG" => $this->t('PAPOUANE-NEOGUINEENNE (PNG)'),
        "PRY" => $this->t('PARAGUAYENNE (PRY)'),
        "PER" => $this->t('PERUVIENNE (PER)'),
        "PHL" => $this->t('PHILIPPINE (PHL)'),
        "POL" => $this->t('POLONAISE (POL)'),
        "PRI" => $this->t('PORTORICAINE (PRI)'),
        "PRT" => $this->t('PORTUGAISE (PRT)'),
        "QAT" => $this->t('QATARIENNE (QAT)'),
        "ROU" => $this->t('ROUMAINE (ROU)'),
        "RUS" => $this->t('RUSSE (RUS)'),
        "RWA" => $this->t('RWANDAISE (RWA)'),
        "LCA" => $this->t('SAINT-LUCIENNE (LCA)'),
        "SMR" => $this->t('SAINT-MARINAISE (SMR)'),
        "VCT" => $this->t('SAINT-VINCENTAISE-ET-GRENADINE (VCT)'),
        "SLV" => $this->t('SALVADORIENNE (SLV)'),
        "STP" => $this->t('SANTOMEENNE (STP)'),
        "SAU" => $this->t('SAOUDIENNE (SAU)'),
        "SEN" => $this->t('SENEGALAISE (SEN)'),
        "SRB" => $this->t('SERBE (SRB)'),
        "SCG" => $this->t('SERBIE ET MONTENEGRO (SCG)'),
        "SYC" => $this->t('SEYCHELLOISE (SYC)'),
        "SLE" => $this->t('SIERRA-LEONAISE (SLE)'),
        "SGP" => $this->t('SINGAPOURIENNE (SGP)'),
        "SVK" => $this->t('SLOVAQUE (SVK)'),
        "SVN" => $this->t('SLOVENE (SVN)'),
        "SOM" => $this->t('SOMALIENNE (SOM)'),
        "SDN" => $this->t('SOUDANAISE (SDN)'),
        "LKA" => $this->t('SRI-LANKAISE (LKA)'),
        "ZAF" => $this->t('SUD-AFRICAINE (ZAF)'),
        "KOR" => $this->t('SUD-CORÉENNE (KOR)'),
        "SSD" => $this->t('SUD-SOUDANAISE (SSD)'),
        "SWE" => $this->t('SUEDOISE (SWE)'),
        "CHE" => $this->t('SUISSE (CHE)'),
        "SUR" => $this->t('SURINAMAISE (SUR)'),
        "SWZ" => $this->t('SWAZIE (SWZ)'),
        "SYR" => $this->t('SYRIENNE (SYR)'),
        "TJK" => $this->t('TADJIKE (TJK)'),
        "TZA" => $this->t('TANZANIENNE (TZA)'),
        "TCD" => $this->t('TCHADIENNE (TCD)'),
        "CZE" => $this->t('TCHEQUE (CZE)'),
        "THA" => $this->t('THAÏLANDAISE (THA)'),
        "TGO" => $this->t('TOGOLAISE (TGO)'),
        "TTO" => $this->t('TRINIDADIENNE (TTO)'),
        "TUN" => $this->t('TUNISIENNE (TUN)'),
        "TKM" => $this->t('TURKMENE (TKM)'),
        "TUR" => $this->t('TURQUE (TUR)'),
        "TUV" => $this->t('TUVALUANE (TUV)'),
        "UKR" => $this->t('UKRAINIENNE (UKR)'),
        "URY" => $this->t('URUGUAYENNE (URY)'),
        "VUT" => $this->t('VANUATUANE (VUT)'),
        "VEN" => $this->t('VENEZUELIENNE (VEN)'),
        "VNM" => $this->t('VIETNAMIENNE (VNM)'),
        "YEM" => $this->t('YEMENITE (YEM)'),
        "ZMB" => $this->t('ZAMBIENNE (ZMB)'),
        "ZWE" => $this->t('ZIMBABWEENNE (ZWE)'),
      ),
      '#default_value' => "BGD",
      '#attributes' => [
        'name' => 'field_student_nationality',
      ]
    );

    $form['student_profession'] = array(
      '#type' => 'select',
      '#title_display' => 'invisible',
      '#prefix' => '<div class="form-group"> <p> Profession / Profession </p>',
      '#suffix' => '</div>',
      "#options" => array(
        "9015" => $this->t("Agriculteur/Farmer / Farmer"),
        "9096" => $this->t("Autres/Others "),
        "60" => $this->t("cadre administratif,technique/Executive "),
        "42" => $this->t("cadre de la fonction publique/Civil Service "),
        "9069" => $this->t("Cadres de la fonction publique "),
        "9195" => $this->t("Chômeurs n'ayant jamais travaillé/Unemployed "),
        "9339" => $this->t("Élèves du primaire/Primary School Student "),
        "9384" => $this->t("Élèves du secondaire/High School Student "),
        "96" => $this->t("employé administratif,technique/Private Service "),
        "9177" => $this->t("Employés civils et agents de service de la fonction publique "),
        "9204" => $this->t("Employés de commerce "),
        "15" => $this->t("étudiant (université)/University Student "),
        "9393" => $this->t("Étudiants (études supérieures) "),
        "9042" => $this->t("Ingénieurs/Engineer "),
        "9357" => $this->t("Militaires du contingent "),
        "114" => $this->t("ouvrier/Worker "),
        "9222" => $this->t("Ouvriers qualifiés de type industriel "),
        "9366" => $this->t("Personnes diverses sans activité professionnelle de moins de 60 ans (sauf retraités) "),
        "9186" => $this->t("Policiers et militaires/Police and Soldier "),
        "69" => $this->t("professeur, enseignant/Professor,Teacher "),
        "9078" => $this->t("Professeurs, professions scientifiques "),
        "87" => $this->t("profession de la santé, travail social/Doctor,Medical Service "),
        "51" => $this->t("profession libérale/Independent Profession "),
        "9087" => $this->t("Professions de l'information/IT Sector "),
        "9123" => $this->t("Professions intermédiaires de la santé et du travail social "),
        "9060" => $this->t("Professions libérales "),
        "123" => $this->t("retraité/Retired "),
        "9321" => $this->t("sans activité prof./Without Professional Activities "),
        "9159" => $this->t("Techniciens/Technician "),
      ),
      '#title' => $this->t('Profession / Profession'),

    );

    $form['student_address'] = array(
      '#type' => 'textfield',
      '#prefix' => '<div class="form-group">',
      '#suffix' => '</div>',
      '#title' => $this->t('Adresse / Address '),

    );

    $form['student_postcode'] = array(
      '#type' => 'textfield',
      '#prefix' => '<div class="form-group">',
      '#suffix' => '</div>',
      '#title' => $this->t('Code postal / Postal code'),

    );

    $form['student_city'] = array(
      '#type' => 'textfield',
      '#prefix' => '<div class=" form-group">',
      '#suffix' => '</div>',
      '#title' => $this->t('Ville / City'),

    );

    $form['student_courseCategory'] = array(
      '#type' => 'select',
      '#prefix' => '<div class=" form-group"><p> Choisissez une catégorie de cours | Select a course category <p>',
      '#suffix' => '</div>',
      '#title' => ('Choisissez une catégorie de cours | Select a course category'),
      '#options' => array(
        'Adult' => $this->t('Adults (From 16 years) '),
        'Children' => $this->t('Children (9-12 years)'),
        'Teenagers' => $this->t('Teenagers (13 to 15 years)')
      ),
      '#title_display' => 'invisible',

    );

    $form['student_courseLevel'] = array(
      '#type' => 'select',
      '#prefix' => '<div class=" form-group"><p> Choisissez un niveau de cours | Select a course level  <p>',
      '#suffix' => '</div>',
      '#title' => ('Choisissez un niveau de cours | Select a course level '),
      '#options' => array(
        'Placement Test' => $this->t('Je souhaite passer un test de placement | I would like to take a placement test'),
        'A1-3' => $this->t('Extensive Adult A1-3'),
        'B1-3' => $this->t('Extensive Adult A1-3'),
        'Prim 4' => $this->t('Children (Prim 4)'),
        'ADO A2-4' => $this->t('Teenager A2-4 (ADO A2-4)'),
      ),
      '#title_display' => 'invisible',

    );

    $form['student_know'] = array(
      '#type' => 'select',
      '#prefix' => '<div class=" form-group"><p> Comment j\'ai eu connaissance de ces cours | How did I know about these courses  </p>',
      '#suffix' => '</div>',
      '#title' => ('Comment j\'ai eu connaissance de ces cours | How did I know about these courses'),
      '#options' => array(
        'J\'ai déjà étudié ici auparavant | I have already studied at the French Institute' => $this->t('J\'ai déjà étudié ici auparavant | I have already studied at the French Institute'),
        'Publicité extérieure (affiches, métro-lights, city-lights...) | Outdoor avdertising (posters, metro-lights, city-lights...)' => $this->t('Publicité extérieure (affiches, métro-lights, city-lights...) | Outdoor avdertising (posters, metro-lights, city-lights...)'),
        'From an advertisement in the press' => $this->t('From an advertisement in the press'),
        'Moteur de recherche internet | From a search on the Internet' => $this->t('Moteur de recherche internet | From a search on the Internet'),
        'Publicité sur internet | From an advertisement on the Internet ' => $this->t('Publicité sur internet | From an advertisement on the Internet '),
        'Publicité sur internet | From an advertisement on the Internet ' => $this->t('Publicité sur internet | From an advertisement on the Internet '),
        'Par l\'intermédiaire d\'une autre personne (bouche à oreille) | Recommended by another person' => $this->t('Par l\'intermédiaire d\'une autre personne (bouche à oreille) | Recommended by another person'),
        'Salons ou événements culturels | During a public event' => $this->t('Salons ou événements culturels | During a public event'),
        'Radio | From an advertisement on the radio ' => $this->t('Radio | From an advertisement on the radio '),
        'Je vis ou travaille dans le quartier | I live or work in the neighbourhood ' => $this->t('Je vis ou travaille dans le quartier | I live or work in the neighbourhood '),
        'Autre | Other : ' => $this->t('Autre | Other : '),
      ),
      '#attributes' => [
        'name' => 'name_student_know',
      ],
      '#title_display' => 'invisible',

    );

    $form['student_otherKnow'] = array(
      '#type' => 'textfield',
      '#prefix' => '<div class="form-group">',
      '#suffix' => '</div>',
      '#title' => $this->t('Other Reasons'),
      '#attributes' => [
        'id' => 'other_know',
      ],
      '#states' => [
        'visible' => [
          ':input[name="name_student_know"]' => ['value' => 'Autre | Other : '],
        ]
      ],
    );


    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#prefix' => '<div class="my-2">',
      '#suffix' => '</div>',
      '#value' => $this->t('Valider | Submit'),
      '#button_type' => 'primary btn btn-primary rounded p-2',
    );

    return $form;
  }


  public function submitForm(array &$form, FormStateInterface $form_state) {

    $field = $form_state->cleanValues()->getValues();
    $contentType = 'pre_enrollment';

    $node = Node::create(['type' => $contentType]);

    $node->title = "Student Advanced Courses Registration Info";
    $node->field_student_type = $field['student_type'];

    if($field['student_type'] ===  "Returning student"){
      $node->field_student_type = $field['student_renewal'];
    }

    $node->field_student_gender = $field['student_gender'];
    $node->field_student_fname = $field['student_fname'];
    $node->field_student_lname = $field['student_lname'];
    $node->field_student_telephone = $field['student_telephone'];
    $node->field_student_email = $field['student_email'];
    $node->field_student_dob = $field['student_dob'];
    $node->field_student_nidpassport = $field['student_nidpassport'];
    $node->field_student_nationality = $field['student_nationality'];
    $node->field_student_profession = $field['student_profession'];
    $node->field_student_address = $field['student_address'];
    $node->field_student_postcode = $field['student_postcode'];
    $node->field_student_city = $field['student_city'];
    $node->field_student_courseCategory = $field['student_courseCategory'];
    $node->field_student_courseLevel = $field['student_courseLevel'];
    $node->field_student_know = $field['student_know'];

    // Take text input in case anyone selects other
    if ($field['student_know'] === 'Autre | Other : ') {
      $node->field_student_know = $field['student_otherKnow'];
    }
    $node->save();
  }
}
