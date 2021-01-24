<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use PDF;
  
class PDFController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generatePDF()
    {
        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y')
        ];
          
        $pdf = PDF::loadView('pdf/pdf', $data);
    
        return $pdf->download('itsolutionstuff.pdf');
    }

    public function meow()
    {
        $data = [
            'title' => '123456',
            'date' => date('m/d/Y')
        ];
          
        $pdf = PDF::loadView('pdf/pdf', $data);
    
        return $pdf->stream('itsolutionstuff.pdf');
    }
}