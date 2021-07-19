<?php

declare(strict_types=1);

namespace App\Controller;

use App\UseCase\addDevice\AddDeviceInteractor;
use App\UseCase\deleteDevice\DeleteDeviceInteractor;
use App\UseCase\editDevice\EditDeviceInteractor;
use App\UseCase\getDevice\GetDeviceInteractor;
use App\UseCase\getDeviceList\GetDeviceListInteractor;
use Exception;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class DeviceController extends AbstractController
{
    /**
     * @Route("/api/v1/device/{deviceNumber}", methods="GET")
     */
    public function showDevice($deviceNumber, GetDeviceInteractor $getDeviceInteractor): Response
    {
        try {
            $device = $getDeviceInteractor->execute((int)$deviceNumber);
            return new JsonResponse($device, 200);
        } catch (Throwable $exception) {
            return new Response($exception->getMessage(), 404);
        }
    }

    /**
     * @Route("/api/v1/device", methods="GET", priority=2)
     * @param GetDeviceListInteractor $getDeviceListInteractor
     * @return Response
     */
    public function showDeviceList(GetDeviceListInteractor $getDeviceListInteractor): Response
    {
        try {
            $deviceList = $getDeviceListInteractor->execute();

            return new JsonResponse($deviceList, 200);
        } catch (Throwable $exception) {
            return new Response($exception->getMessage(), 500);
        }
    }

    /**
     * @Route("/api/v1/device", methods="POST")
     */
    public function addDevice(Request $request, AddDeviceInteractor $addDeviceInteractor): Response
    {
        $requestContent = json_decode($request->getContent(), true);

        $addDeviceRequest = new stdClass();
        $addDeviceRequest->deviceId = (int)$requestContent['deviceId'];
        $addDeviceRequest->deviceType = $requestContent['deviceType'];
        $addDeviceRequest->isDamagePossible = $requestContent['isDamagePossible'];

        try {
            $addDeviceInteractor->execute($addDeviceRequest);

            return new JsonResponse('', 201);
        } catch (Throwable $exception) {
            return new Response($exception->getMessage(), 500);
        }
    }

    /**
     * @Route("/api/v1/device", methods="PUT")
     */
    public function editDevice(Request $request, EditDeviceInteractor $editDeviceInteractor): Response
    {
        $requestContent = json_decode($request->getContent(), true);

        $editDeviceRequest = new stdClass();
        $editDeviceRequest->deviceId = (int)$requestContent['deviceId'];
        $editDeviceRequest->deviceType = $requestContent['deviceType'];
        $editDeviceRequest->isDamagePossible = $requestContent['isDamagePossible'];

        try {
            $result = $editDeviceInteractor->execute($editDeviceRequest);

            if (!$result) {
                throw new Exception('Error Occured');
            }
            return new JsonResponse('Edit was Successful', 200);
        } catch (Throwable $exception) {
            return new Response($exception->getMessage(), 500);
        }
    }

    /**
     * @Route("/api/v1/device/{deviceNumber}", methods="DELETE")
     */
    public function deleteDevice($deviceNumber, DeleteDeviceInteractor $deleteDeviceInteractor): Response
    {
        try {
            $device = $deleteDeviceInteractor->execute((int)$deviceNumber);

            if ($device) {
                return new JsonResponse($device, 200);
            }

            throw new Exception('Delete was not successful');

        } catch (Throwable $exception) {
            return new JsonResponse($exception->getMessage(), 404);
        }
    }
}
