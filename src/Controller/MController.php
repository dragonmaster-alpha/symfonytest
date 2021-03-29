<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use DateTimeZone;
use DateTime;

class MController extends AbstractController
{
    /**
     * @Route("/m", name="m")
     */
    public function index(): Response
    {
        return $this->render('m/index.html.twig', [
            'controller_name' => 'MController',
        ]);
    }

    public function test(Request $request)
    {   
        $request = Request::createFromGlobals();
        $date = $request->request->get('date');
        $timezone  = $request->request->get('timezone');
        // Create two timezone objects
        $dateTimeZone1 = new DateTimeZone("UTC");
        $dateTimeZone2 = new DateTimeZone($timezone);
        // Timestamp to each zone
        $dateTime1 = new DateTime("now", $dateTimeZone1);
        $dateTime2 = new DateTime("now", $dateTimeZone2);
        // Get the time offsets as seconds/60
        $timeOffset = $dateTimeZone2->getOffset($dateTime1)/60;
        $timeOffset_str = $timeOffset > 0 ? "+".$timeOffset : $timeOffset;
        // Get the date object of specified date
        $dateObj = DateTime::createFromFormat('Y-m-d', $date);
        // Get the year, month of specified date
        $year = $dateObj->format('Y');
        $month = $dateObj->format('m');
        $month_str = $dateObj->format('F');
        // Number of days of certain month
        $number = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        // Number of days of February
        $feb = cal_days_in_month(CAL_GREGORIAN, 2, $year);

        return $this->render('m/test.html.twig', [
            'timezone' => $timezone,
            'timeOffset' => $timeOffset_str,
            'feb' => $feb,
            'month' => $month_str,
            'number' => $number
        ]);
    }
}
