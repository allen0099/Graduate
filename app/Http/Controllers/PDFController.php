<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use PDF;

use App\Models\Order;
use App\Models\User;
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

    public function OrderPdf(Request $request)
    {
        $document_id = $request->document_id;
        if (!is_null($document_id)) {

            $result = Order::where('document_id', $document_id)->first();

            $sizeList = ['S'=>0,'M'=>0, 'L'=>0, 'XL'=>0];
            $colorList = ['白'=>0, '黃'=>0, '橘'=>0, '灰'=>0, '藍'=>0, '紫'=>0];
            $totle = 0;

            if (!is_null($result)) {

                $cloth_type = $result->owner->username[0] > "5" ? "碩士服" : "學士服";
                foreach($result->sets as $i => $i_value) {
                    $colorList[$i_value->accessory->spec] += 1;
                    $sizeList[$i_value->cloth->spec] += 1;
                    $totle += 1;
                }

                $data = [
                    'order' => $result,
                    'sizeList' => $sizeList,
                    'colorList' => $colorList,
                    'totle' => $totle,
                    'one_set_price' => 1000,
                    'cloth_type' => $cloth_type
                ];

                $pdf = PDF::loadView('pdf/pdf', $data);
            
                return $pdf->stream($result->owner->username.'-order.pdf');
            }
        }
        return '資料錯誤';
    }
}