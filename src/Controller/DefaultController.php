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

}
