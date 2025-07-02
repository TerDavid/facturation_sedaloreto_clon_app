<?php

namespace App\CoreFacturalo;

class Template
{
    public function pdf($template, $company, $document, $format_pdf)
    {

        if($template === 'credit' || $template === 'debit') {
            $template = 'note';
        }
        if($template ==='workOrder'){
            $template = 'workOrder';
        }

        $template_name = $template.'_'.$format_pdf;
        $template_name = $this->findCustomTemplate($template_name);

        $template = 'pdf.'.$template_name;
        return self::render($template, $company, $document);
    }

    private function findCustomTemplate($template_name)
    {
        // $template = \App\Models\Tenant\PdfTemplateConfiguration::where('template_name', $template_name)->first();
        $template = null;

        return $template ? $template->template_file : $template_name;
    }

    public function pdf2($template, $company, $document, $format_pdf,$payments)
    {

        $template = 'pdf.'.$template.'_'.$format_pdf;
        return self::render2($template, $company, $document,$payments);
    }

    public function xml($template, $company, $document)
    {
        return self::render('xml.'.$template, $company, $document);
    }

    private function render($view, $company, $document)
    {
        $ff=__DIR__.'/Templates';
        view()->addLocation(__DIR__.'/Templates');
        return view($view, compact('company', 'document'))->render();
    }

    private function render2($view, $company, $document,$payments)
    {
        $id_payment = $payments;
        view()->addLocation(__DIR__.'/Templates');
        return view($view, compact('company', 'document','id_payment'))->render();
    }
    public function depuration($var){
            print_r($var);
            exit;
    }

    public function pdfFooter()
    {
        view()->addLocation(__DIR__.'/Templates');
        return view('pdf.partials.footer')->render();
    }
}
