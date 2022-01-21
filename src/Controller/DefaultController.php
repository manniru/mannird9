<?php

namespace Drupal\mannird9\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DefaultController extends ControllerBase {

  protected $repository;

  public function controller1() {

    return ['#markup' => '<table>
    <tr>
      <th>Company</th>
      <th>Contact</th>
      <th>Country</th>
    </tr>
    <tr>
      <td>Alfreds Futterkiste</td>
      <td>Maria Anders</td>
      <td>Germany</td>
    </tr>
    <tr>
      <td>Centro comercial Moctezuma</td>
      <td>Francisco Chang</td>
      <td>Mexico</td>
    </tr>
    <tr>
      <td>Ernst Handel</td>
      <td>Roland Mendel</td>
      <td>Austria</td>
    </tr>
    <tr>
      <td>Island Trading</td>
      <td>Helen Bennett</td>
      <td>UK</td>
    </tr>
    <tr>
      <td>Laughing Bacchus Winecellars</td>
      <td>Yoshi Tannamuri</td>
      <td>Canada</td>
    </tr>
    <tr>
      <td>Magazzini Alimentari Riuniti</td>
      <td>Giovanni Rovelli</td>
      <td>Italy</td>
    </tr>
  </table>'];
  }


  public function google()
  {
    // return ['#markup' => '<iframe src="https://google.com" title="W3Schools Free Online Web Tutorials"></iframe>'];

      return [
        '#type' => 'inline_template',
        '#template' => '<iframe width="600" height="700" src="https://www.youtube.com/embed/RyLwophXGFI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',];
  }

  public function registration_view($id = null) {

    $request = \Drupal::request();
    if ($route = $request->attributes->get(\Symfony\Cmf\Component\Routing\RouteObjectInterface::ROUTE_OBJECT)) {
      $route->setDefault('_title', '<none>');
    }

    $reg = \Drupal::database()->query("select * from _registrations where id=$id")->fetchObject();
    // print('<pre>' . print_r($reg, TRUE) . '</pre>'); exit();

    /*
    return [
      '#markup' => "<table border='1'>
      <tr>
        <th>Name</th>
        <th>Value</th>
      </tr>
      <tr>
        <td>Name</td>
        <td>$reg->name</td>
      </tr>
      <tr>
        <td>Phone Number</td>
        <td>$reg->phone</td>
      </tr>
    </table>"
    ];
    */
    return [
      '#theme' => 'registration',
      '#reg' => $reg,
    ];
  }

  public function registration_pdf($id = null)
  {
    $reg = \Drupal::database()->query("select * from _registrations where id=$id")->fetchObject();
    $pdf = new \FPDF('P','mm','A4');
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->setXY(50, 100);
    $pdf->Cell(0,10,'BRILLIANT ESYSTEMS LIMITED', 0, 0);
    $pdf->Ln();
    $pdf->Cell(0,10,"Name: $reg->name", 0, 0, 'C');
    $pdf->Ln();
    $pdf->Cell(0,10,"Gender: $reg->gender", 0, 0, 'C');
    $pdf->Ln();
    $pdf->Cell(0,10,"Gender: $reg->gender", 0, 0, 'C');
    $pdf->Ln();
    $pdf->Cell(0,10,"Gender: $reg->gender", 0, 0, 'C');
    $pdf->Ln();
    $pdf->Cell(0,10,"Gender: $reg->gender", 0, 0, 'C');
    $pdf->Ln();
    $pdf->Cell(0,10,"Gender: $reg->gender", 0, 0, 'C');
    $pdf->Ln();
    $pdf->Cell(0,10,"Gender: $reg->gender", 0, 0, 'C');
    $pdf->Ln();
    $pdf->Cell(0,10,"Gender: $reg->gender", 0, 0, 'C');
    $pdf->Ln();
    $pdf->Cell(0,10,"Gender: $reg->gender", 0, 0, 'C');
    $pdf->Ln();
    $pdf->Cell(0,10,"Gender: $reg->gender", 0, 0, 'C');
    $pdf->Ln();
    $pdf->Cell(0,10,"Gender: $reg->gender", 0, 0, 'C');
    $pdf->Ln();
    $pdf->Cell(0,10,"Gender: $reg->gender", 0, 0, 'C');
    $pdf->Ln();

    $pdf->Output();
    exit();

    return ['#markup' => 'PDF'];
  }

  public function dashboard($var = null)
  {
    $number_of_rows = \Drupal::database()->select('_registrations')->countQuery()->execute()->fetchField();

    return [
      '#markup' => '<div class="row">
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3>'.$number_of_rows.'</h3>

          <p>Registrations</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="http://localhost/d9/registration" class="small-box-footer">Click to Register <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-success">
        <div class="inner">
          <h3>53<sup style="font-size: 20px">%</sup></h3>

          <p>Payments</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-warning">
        <div class="inner">
          <h3>44</h3>

          <p>User Registrations</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>65</h3>

          <p>Unique Visitors</p>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div>
  <br />

  <div class="row">
  <div class="col-md-4">
    <!-- Widget: user widget style 2 -->
    <div class="card card-widget widget-user-2">
      <!-- Add the bg color to the header using any of the bg-* classes -->
      <div class="widget-user-header bg-warning">
        <div class="widget-user-image">
          <img class="img-circle elevation-2" src="https://mannir.net/images/ibrahim.jpg" alt="User Avatar">
        </div>
        <!-- /.widget-user-image -->
        <h3 class="widget-user-username">Ibrahim Kabiru Bala</h3>
        <h5 class="widget-user-desc">Accountant</h5>
      </div>
      <div class="card-footer p-0">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a href="#" class="nav-link">
              Projects <span class="float-right badge bg-primary">31</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              Office Address <span class="float-right badge bg-info">5</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              Completed Projects <span class="float-right badge bg-success">12</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="https://fb.com/mannir" class="nav-link">
              Followers <span class="float-right badge bg-danger">842</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <!-- /.widget-user -->
  </div>
  <!-- /.col -->
  <div class="col-md-4">
    <!-- Widget: user widget style 1 -->
    <div class="card card-widget widget-user">
      <!-- Add the bg color to the header using any of the bg-* classes -->
      <div class="widget-user-header bg-info">
        <h3 class="widget-user-username">Alexander Pierce</h3>
        <h5 class="widget-user-desc">Founder & CEO</h5>
      </div>
      <div class="widget-user-image">
        <img class="img-circle elevation-2" src="../dist/img/user1-128x128.jpg" alt="User Avatar">
      </div>
      <div class="card-footer">
        <div class="row">
          <div class="col-sm-4 border-right">
            <div class="description-block">
              <h5 class="description-header">3,200</h5>
              <span class="description-text">SALES</span>
            </div>
            <!-- /.description-block -->
          </div>
          <!-- /.col -->
          <div class="col-sm-4 border-right">
            <div class="description-block">
              <h5 class="description-header">13,000</h5>
              <span class="description-text">FOLLOWERS</span>
            </div>
            <!-- /.description-block -->
          </div>
          <!-- /.col -->
          <div class="col-sm-4">
            <div class="description-block">
              <h5 class="description-header">35</h5>
              <span class="description-text">PRODUCTS</span>
            </div>
            <!-- /.description-block -->
          </div>
          <!-- /.col -->
        </div>

  ',
  '#attached' => [ 'library' => ['mannird9/adminlte3', ]],
];
  }

}
