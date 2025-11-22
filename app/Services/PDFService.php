<?php

namespace App\Services;

use App\Models\Booking;

class PDFService
{
    // Generate booking invoice PDF
    public function generateInvoice(Booking $booking)
    {
        try {
            // For now, we'll return a simple HTML that can be printed
            // You can integrate a PDF library like DomPDF or TCPDF later
            
            $html = view('frontend.bookings.invoice', compact('booking'))->render();
            
            return $html;
            
        } catch (\Exception $e) {
            throw $e;
        }
    }
}