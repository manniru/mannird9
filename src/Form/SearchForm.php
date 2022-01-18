<?php

namespace Drupal\mannird9\Form;

use Drupal\Core\Database\Driver\mysql\Connection;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Link;

// use Drupal\mannirigr\Mannir\gombe\GombePdf;
// use PHPExcel;
// use PHPExcel_IOFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
// use PhpOffice\PhpSpreadsheet\IOFactory;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class SearchForm extends FormBase {

  protected $database;
  protected $session;

  protected $accepted_domains = ['gmail.com', 'yahoo.com'];

  public function __construct(Connection $database, SessionInterface $session) {
    $this->database = $database;
    $this->session = $session;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database'),
      $container->get('session')
    );
  }
  /**
   * {@inheritDoc}
   */
  public function getFormId() {
    return 'search_filter_form';
  }

  /**
   * {@inheritDoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {


    $form['f1'] = ['#type' => 'container', '#attributes' => ['class' => ['container-inline'],]];

   $search = $this->session->get('mannirigr.search', '');
//    $this->messenger()->addMessage("search = $search");
//    $sms = \Drupal::service('session');


    $head = ($_SESSION['head']) ?: $_SESSION['head'];
    /*
    // $heads = $this->database->query("select distinct head_code, head_name from _sub_heads sh order by head_name")->fetchAllKeyed();
    // $heads = ['' => '-Select Head-', '*' => 'All Heads'] + $heads;
    $subheads = $this->database->query("SELECT substr(subhead, 1, 60) FROM _registrations")->fetchAllKeyed();
    $subheads = array_combine(array_keys($subheads), array_keys($subheads));
    $subheads = ['' => '-Select Sub-Head', '*' => 'All Sub-Heads'] + $subheads;
    *

    if($head) {
      // $subheads = $this->database->query("select distinct subhead_code, subhead_name from _sub_heads sh where sh.head_code = '$head' order by subhead_name")->fetchAllKeyed();
      // $subheads = ['' => '-Select Sub-Head', '*' => 'All Sub-Heads'] + $subheads;
    }

    // $form['f1'] = ['#type' => 'container', '#attributes' => ['class' => ['container-inline'],],];
    $form['f1'] = [
      '#type' => 'details',
      '#open' => TRUE,
      '#title' => $this->t('Search, Filter & Exports'),
      '#attributes' => ['class' => ['container-inline'],]
    ];
    // $form['search']['name'] = ['#type' => 'textfield', '#title' => $this->t('Name')];

    $fields = $this->database->query("DESCRIBE `_payments`")->fetchCol(0);
    $fields = ['' => '-Select Field-'] + $fields;
    // print('<pre>' . print_r($fields, TRUE) . '</pre>'); exit();

    // $form['f1']['search_word']['#attached']['css'] = array(
    //   array(
    //     'data' => 'input {
    //       width: 100%;
    //     }',
    //     'type' => 'inline',
    //   ),
    // );
//    print('<pre>' . print_r($heads, TRUE) . '</pre>'); exit();

/*
    $form['f1']['head'] = [
      '#type' => 'select',
      // '#title' => $this->t('Select Revenue Head'),
      '#options' => $heads,
      '#default_value' => ($_SESSION['head']) ?: $_SESSION['head'],
      '#size' => 1,
      // '#weight' => '0',
      '#ajax' => [
        'callback' => [$this, 'updateSubheadByHead'],
        'event' => 'change',
        'progress' => ['type' => 'throbber','message' => NULL,],
        'wrapper' => 'subhead-dropdown',
      ],
//      '#prefix' => '<div class="pure-u-1 pure-u-md-1-2">',
//      '#suffix' => '</div>',
    ];
    */

    /*

    $form['f1']['subhead'] = [
      '#id' => 'subhead-dropdown',
      '#type' => 'select',
      // '#title' => $this->t('Select Revenue Sub-head'),
      '#options' => $subheads,
      '#size' => 1,
      // '#weight' => '0',
//      '#prefix' => '<div class="pure-u-1 pure-u-md-1-1">',
     '#suffix' => '<br />',
      '#default_value' => ($_SESSION['subhead']) ?: $_SESSION['subhead'],
    ];

      $form['f1']['datefrom'] = [
        '#type' => 'date',
        // '#title' => $this->t('Date From'),
        '#default_value' => ($_SESSION['datefrom']) ?: $_SESSION['datefrom'],
      ];

      $form['f1']['dateto'] = [
        '#type' => 'date',
        // '#title' => $this->t('Date To'),
        '#default_value' => ($_SESSION['dateto']) ?: $_SESSION['dateto'],
      ];
      */

      //
        $form['f1']['keyword'] = [
          '#type' => 'search', '#size' => 20,
          '#default_value' => ($_SESSION['keyword']) ?: $_SESSION['keyword'],
          '#placeholder' => $this->t('Enter search term'),
          ];

      // exit($current_path);




      /*
      $form['f1']['search_by'] = [
        '#type' => 'select',
        //          '#title' => $this->t('Search By'),
        '#options' => array_combine($fields, $fields),
        // '#default_value' => isset($_SESSION['search_by']) ? $_SESSION['search_by'] : 'rrr',
        '#default_value' => 'rrr'
      ];

      // $css = 'img { outline: 2px solid #F00; }';
      // $options = array('type' => 'inline');
      // $build['#attached']['css'][$css] = $options;

      $form['f1']['search_word'] = [
        '#type' => 'textfield',
        '#attributes' => array('placeholder' => 'Search Word'),
        '#default_value' => isset($_SESSION['search_word']) ? $_SESSION['search_word'] : '',
        // '#title' => $this->t('Subject'),
        '#size' => 30,
        // '#attached' => ['css' => ]
        // '#attributes' => array('maxlength' => 4, 'size' => 4),
      ];
      */

      $form['f1']['actions'] = ['#type' => 'actions'];
      $form['f1']['actions']['submit'] = ['#type' => 'submit', '#value' => 'Search'];
      $form['f1']['actions']['reset'] = ['#type' => 'submit', '#value' => 'Reset'];
      $form['f1']['actions']['pdf'] = ['#type' => 'submit', '#value' => 'PDF'];
      $form['f1']['actions']['excel'] = ['#type' => 'submit', '#value' => 'Excel'];
      $form['f1']['actions']['excel2'] = ['#type' => 'submit', '#value' => 'Excel Summary'];

    return $form;
  }

  public function updateSubheadByHead($form, FormStateInterface &$form_state) {

    $value = $form_state->getTriggeringElement()['#value'];
    if ($value) {
      $options = $this->database->query("select distinct subhead_code, subhead_name from _sub_heads sh where sh.head_code = '$value' order by subhead_name")->fetchAllKeyed();
      $options = ['' => '-Select Sub-Head-', '*' => 'All Sub-Heads'] + $options;
    }

    return [
      '#name' => 'subhead',
      '#type' => 'select',
      // '#title' => "$value ::",
      '#default_value' => NULL,
      '#empty_value' => '',
      '#options' => $options,
      '#prefix' => '<div id="subhead-dropdown">',
      '#suffix' => '</div>',
      '#validated' => TRUE,
      '#weight' => 16,
      ];
    }

  /**
   * {@inheritDoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $op = $form_state->getValue('op');
    // // exit($op);

    // $form_state->unsetValue('form_build_id');
    // $form_state->unsetValue('form_token');
    // // $form_state->unsetValue('op');
    // $form_state->unsetValue('submit');
    // $values = $form_state->getValues();


    // $head = $form_state->getValue('head');
    // $subhead = $form_state->getValue('subhead');
    // $datefrom = $form_state->getValue('datefrom');
    // $dateto = $form_state->getValue('dateto');
    // $month = $form_state->getValue('month');
    // $search_by = $form_state->getValue('search_by');
    // $search_word = $form_state->getValue('search_word');

    // if($subhead) $_SESSION['subhead'] = $subhead;
    // if($datefrom) $_SESSION['datefrom'] = $datefrom;
    // if($dateto) $_SESSION['dateto'] = $dateto;
    // if($month) $_SESSION['month'] = $month;
    // if($search_by) $_SESSION['search_by'] = $search_by;
    // if($search_word) $_SESSION['search_word'] = $search_word;

    // exit($search_word);

    $path = \Drupal::service('path.current')->getPath();


    switch ($op) {
      case 'PDF':
        $form_state->unsetValue('form_build_id');
        $form_state->unsetValue('form_token');
        $form_state->unsetValue('op');
        $form_state->unsetValue('submit');

        $values = $form_state->getValues();
        if($path == '/reports') {
          $form_state->setRedirect('mannirigr.reportspdf', ['month' => $_SESSION['month']]);
        }
        elseif($path == '/reports/remita') {
          $form_state->setRedirect('mannirigr.reports_pdf', [
            'head' => $head,
            'subheadcode' => $subhead,
            'datefrom' => $datefrom,
            'dateto' => $dateto,
            'search_by' => $search_by,
            'search_word' => $search_word,
            ]);
        }

        elseif($path == '/reports/isw') {
          $form_state->setRedirect('mannirigr.reports_all', ['head' => $head, 'subhead' => $subhead, 'datefrom' => $datefrom, 'dateto' => $dateto]);
        }

        elseif ($path == '/payments/remita' || $path == '/payments') {
          $form_state->setRedirect('mannirigr.reportspdf', ['type' => 'remita', 'head' => $head, 'subhead' => $subhead, 'datefrom' => $datefrom, 'dateto' => $dateto]);
        }
        elseif ($path == '/payments/interswitch') {
          $form_state->setRedirect('mannirigr.reportspdf', ['type' => 'interswitch', 'head' => $head, 'subhead' => $subhead, 'datefrom' => $datefrom, 'dateto' => $dateto]);
        }
        elseif ($path == '/payments/others') {
          $form_state->setRedirect('mannirigr.reportspdf', ['type' => 'others', 'head' => $head, 'subhead' => $subhead, 'datefrom' => $datefrom, 'dateto' => $dateto]);
        }
        elseif ($path == '/payments/pos') {
          $form_state->setRedirect('mannirigr.reportspdf', ['type' => 'pos', 'head' => $head, 'subhead' => $subhead, 'datefrom' => $datefrom, 'dateto' => $dateto]);
        }
        else {
          $form_state->setRedirect('mannirigr.reports_all', ['head' => $head, 'subhead' => $subhead, 'datefrom' => $datefrom, 'dateto' => $dateto]);
        }


        break;

      case 'Excel':
        // $headcode = $_SESSION['head'];
        // $subheadcode = $_SESSION['subheadcode'];
        // $datefrom = $_SESSION['datefrom'];
        // $dateto = $_SESSION['dateto'];

        // $headcode = $form_state->getValue('head');

        // exit($_SESSION['subhead']);



    $link = Link::createFromRoute('Excel File Generated!, Click this Link to Download Generated Excel File', 'mannirigr.reportsexcel',
    [
      'path' => $path,
      'head' => $head,
      'subhead' => $subhead,
      'datefrom' => $datefrom,
      'dateto' => $dateto,
      ]);

      // \Drupal::messenger()->addMessage($this->t('<strong>You can click this <a href=="@link">Link</a> to Download Excel file</strong>', ['@link' => $url->toString()]));
      \Drupal::messenger()->addMessage($link);



        // $url = Url::fromRoute('mannirigr.excel_remita',
        // [
        //   'head' => $_SESSION['head'],
        //   'subhead' => $_SESSION['subhead'],
        //   'datefrom' => $_SESSION['datefrom'],
        //   'dateto' => $_SESSION['dateto'],
        //   ]);



            // \Drupal::messenger()->addMessage($this->t('<strong>You can click this <a href=="@link">Link</a> to Download Excel file</strong>', ['@link' => $url->toString()]));
            // \Drupal::messenger()->addMessage($link);


        /*
        // mannir
          $form_state->setRedirect('mannirigr.excel_remita', [
            'head' => $_SESSION['head'],
            'subhead' => $_SESSION['subhead'],
            'datefrom' => $_SESSION['datefrom'],
            'dateto' => $_SESSION['dateto'],
            ]);
            */


      /*
      //
    $channel = 'Remita';

    $spreadsheet = new Spreadsheet();
    $Excel_writer = new Xls($spreadsheet);
    //$writer = new Xlsx($spreadsheet);
    $spreadsheet->setActiveSheetIndex(0);
    $sheet = $spreadsheet->getActiveSheet();

    $spreadsheet = new Spreadsheet();
    $Excel_writer = new Xls($spreadsheet);

    switch ($channel) {
      case 'Remita':
        $fields = [
        'DATE_TIME',
        'RRR',
        'PAYER NAME',
        'TOTAL AMOUNT',
        'REVENUE HEAD',
        'REVENUE SUB-HEAD',
      ];


      $query = $this->database->select('_remita', 'py');
      $query = $query->fields('py', ['datetime', 'rrr', 'payerName', 'totalAmount']);
      $query->join('_sub_heads', 'sh', 'py.serviceTypeId = sh.servicetypeId');
      $query->fields('sh', ['head_name', 'subhead_name']);
      $query->condition('py.status', 1);
      // ->addExpression('RANDOM()', 'random_field');
      if($head) $query->condition('py.head', $head);
      if($subhead) $query->condition('py.subhead', $subhead);
      // if($month) $query->condition('py.datetime', $month . '%', 'LIKE'); //$query->escapeLike('month')

      if($datefrom && $dateto) {
        $query->condition('py.datetime', array($datefrom, $dateto), 'BETWEEN');
      }

      // print('<pre>' . print_r("$datefrom , $dateto", TRUE) . '</pre>'); exit();


      // $query->range(0, 10);
      $result = $query->execute()->fetchAllAssoc('rrr', \PDO::FETCH_ASSOC);
      // $lastRow = count($result);

      // print('<pre>' . print_r($result, TRUE) . '</pre>'); exit();


      // exit($lastRow);

      // $spreadsheet->getActiveSheet()->getCell('A'.count($result))->setValue("TOTAL AMOUNT: 0");
      // $total = \Drupal::database()->query("select * from _sub_heads where itemcode = '$head_subhead'")->fetchObject();

      // $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(1, 360, "TOTAL AMOUNT: ");

      $spreadsheet->getActiveSheet()->mergeCells('A1:F1');
      $spreadsheet->getActiveSheet()->mergeCells('A2:F2');
      $spreadsheet->getActiveSheet()->mergeCells('A3:F3');
      $spreadsheet->getActiveSheet()->mergeCells('A4:F4');
      // $spreadsheet->getActiveSheet()->mergeCells('A5:F5');


      if($head_subhead) {
        $hd = \Drupal::database()->query("select * from _sub_heads where itemcode = '$head_subhead'")->fetchObject();
      }

      $spreadsheet->getActiveSheet()->setCellValue('A1', 'GOMBE STATE INTERNAL REVENUE SERVICE - IGR PLATFORM');
      $spreadsheet->getActiveSheet()->setCellValue('A2', "REVENUE HEAD: $hd->head_name");
      $spreadsheet->getActiveSheet()->setCellValue('A3', "REVENUE SUB-HEAD: $hd->subhead_name");
      $spreadsheet->getActiveSheet()->setCellValue('A4', 'DATE RANGE:' . date('F, Y'));

      $styleArray = [
        'borders' => [
            'outline' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                'color' => ['argb' => 'FFFF0000'],
            ],
        ],
    ];


  //   $spreadsheet->getActiveSheet()
  // ->duplicateStyle(
  //     $spreadsheet->getActiveSheet()->getStyle('B2'),
  //     'B3:B7'
  // );

  // $spreadsheet->getActiveSheet()->getStyle('A1:A4')->applyFromArray($styleArray);

      $spreadsheet->getActiveSheet()->fromArray($fields,NULL, 'A5');
      $spreadsheet->getActiveSheet()->fromArray($result, NULL, 'A6');

      // $sheet->setCellValue('A1' , "'".time())->getStyle('A1')->getFont()->setBold(true);

      $styleArray = [
        'font' => [
          'bold' => true,
        ],
        'alignment' => [
          'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
        ],
        'borders' => [
          'top' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          ],
        ],
        'fill' => [
          'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
          'rotation' => 90,
          'startColor' => [
            'argb' => 'FFA0A0A0',
          ],
          'endColor' => [
            'argb' => 'FFFFFFFF',
          ],
        ],
      ];

      $styleArray2 = [
        'borders' => [
          'outline' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            'color' => ['argb' => 'FFFF0000'],
          ],
        ],
      ];

      //$spreadsheet->getActiveSheet()->getStyle('A3')->applyFromArray($styleArray);
      $spreadsheet->getActiveSheet()->getStyle('A1:AA5')->applyFromArray($styleArray);
      $spreadsheet->getActiveSheet()->getStyle('B2:B1000')->getNumberFormat()->setFormatCode('0000-0000-0000');
      $spreadsheet->getActiveSheet()->getStyle('D2:D1000')->getNumberFormat()->setFormatCode('#,##0.00');
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(15);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(40);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

      // $spreadsheet->getActiveSheet()->getStyle('E2:E101')->getNumberFormat()->setFormatCode('[Blue][>=30000]$#,##0;[Red][<20000]$#,##0;$#,##0');

        break;

    case 'Interswitch':

      // exit($head_subhead);

      $fields = ['PaymentDateTime', 'ReceiptNo', 'CustomerName', 'Payment', 'amount', 'ItemCode'];
      $query = $this->database->select('_interswitch', 'tb');
      $query = $query->fields('tb', $fields);
      // $query->addExpression('PaymentDateTime', 'substr(PaymentDateTime, 1, 19)');
      if($month) $query->condition('PaymentDateTime', "%" . $this->database->escapeLike($month) . "%", 'LIKE');
      if($head_subhead) $query->condition('ItemCode', $head_subhead);
      // $query->join('_sub_heads', 'sh', 'py.serviceTypeId = sh.servicetypeId');
      // $query->fields('sh', ['head_name', 'subhead_name']);
      // $query->condition('py.status', 1);
      // $query->condition('py.head', $head);
      // $query->condition('py.subhead', $subhead);
      // $query->range(0, 30);
      $result = $query->execute()->fetchAllAssoc('ReceiptNo', \PDO::FETCH_ASSOC);
      $lastRow = count($result);

      // print('<pre>' . print_r(count($result), TRUE) . '</pre>'); exit();


      $spreadsheet->getActiveSheet()->fromArray($fields,NULL, 'A5');
      $spreadsheet->getActiveSheet()->fromArray($result, NULL, 'A6');

      // title
      $spreadsheet->getActiveSheet()->setCellValue('A1', 'GOMBE STATE INTERNAL REVENUE SERVICE');
      $spreadsheet->getActiveSheet()->setCellValue('A1', 'GOMBE STATE INTERNAL REVENUE SERVICE');

      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(15);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(40);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(50);
      $spreadsheet->getActiveSheet()->getStyle('B2:B1000')->getNumberFormat()->setFormatCode('0000000000');
      $spreadsheet->getActiveSheet()->getStyle('E2:E1000')->getNumberFormat()->setFormatCode('#,##0.00');


      // exit('Interswitch');
    break;
      default:
        # code...
        break;
    }

    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
    $drawing->setName('Logo');
    $drawing->setDescription('Logo');
    $drawing->setPath('modules/custom/mannir/mannirigr/assets/images/gombe_irs.png');
    $drawing->setHeight(100);

    $drawing->setCoordinates('J1');
    $drawing->setOffsetX(1);
    // $drawing->setRotation(25);
    $drawing->getShadow()->setVisible(true);
    $drawing->getShadow()->setDirection(45);


    $drawing->setWorksheet($spreadsheet->getActiveSheet());

    $filename = "IGR_COLLECTIONS_REPORTS_$channel_". date('Y-m-d h:m:s');
*/
    //header('Content-Type: application/vnd.ms-excel');
    //header('Content-Disposition: attachment;filename="'. $filename .'.xls"'); /*-- $filename is  xsl filename ---*/
    // header('Cache-Control: max-age=0');
    // $Excel_writer->save('php://output');


    // $uri = "";

    // $this->messenger()->addMessage($this->t('Successfully deleted managed file %uri', ['%uri' => $subhead]));



      break;

    case 'Excel Summary':
      /*
      // dr zimit
      $form_state->setRedirect('mannirigr.reports_type', [
        'type' => 'excel',
        'headcode' => $_SESSION['head'],
        'subheadcode' => $_SESSION['subhead'],
        'date1' => $_SESSION['date1'],
        'date2' => $_SESSION['date2'],
        'month' => $_SESSION['month'],
        ]);
        */

        $link = Link::createFromRoute('Excel File Generated!, Click this Link to Download Generated Excel File', 'mannirigr.reports_type',
        [
          'type' => 'excel',
          'head' => $head,
          'subhead' => $subhead,
          'datefrom' => $datefrom,
          'dateto' => $dateto,
          'date1' => $date1,
          'date2' => $date2,
          'month' => $month,

          ]);

          // \Drupal::messenger()->addMessage($this->t('<strong>You can click this <a href=="@link">Link</a> to Download Excel file</strong>', ['@link' => $url->toString()]));
          \Drupal::messenger()->addMessage($link);


    break;

      case 'Search':
        $keyword = $form_state->getValue('keyword');
        if ($keyword) $_SESSION['keyword'] = $keyword;
        else $_SESSION['keyword'] = '';
        // exit($search);
        // if ($search) $this->session->set('mannirigr.search', $search);

        // $head = $form_state->getValue('head');
        // $subhead = $form_state->getValue('subhead');
        // if($head) $_SESSION['head'] = $head;
        // if($subhead) $_SESSION['subhead'] = $subhead;

        // $datefrom = $form_state->getValue('datefrom');
        // $dateto = $form_state->getValue('dateto');
        // if($datefrom) $_SESSION['datefrom'] = $datefrom;
        // if($dateto) $_SESSION['dateto'] = $dateto;

        // $sess = \Drupal::service('user.private_tempstore')->get('mannirigr');
        // $sess->set('head', $head);

//         \Drupal::messenger()->addMessage($_SESSION['head']);
      //  exit($_SESSION['subhead']);

        break;

      case 'Reset':
        unset($_SESSION['keyword']);
      //   $this->session->remove('mannirigr.search');
      //   unset($_SESSION['head']);
      //   unset($_SESSION['subhead']);
      //   unset($_SESSION['datefrom']);
      //   unset($_SESSION['dateto']);
      //   unset($_SESSION['search_by']);
      //   unset($_SESSION['search_word']);
      // break;

      default:
        # code...
        break;
    }
  }
}
