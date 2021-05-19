<?php


namespace App\Tests;


use App\Entity\Bookings;
use App\Entity\Room;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class CheckRoomAvailabilityTest extends TestCase
{
    public function dataProviderForPremiumRoom(): array
    {
        return [
            [true, true, true],
            [false, false, true],
            [false, true, true],
            [true, false, false]
        ];
    }

    /**
     * function has to start with Test
     * @dataProvider dataProviderForPremiumRoom
     */
    public function testPremiumRoom(bool $roomVar, bool $userVar, bool $expectedOutput): void
    {
        $room = new Room($roomVar);
        $user = new User($userVar);
        $booking = new Bookings($user, $room, new \DateTime('2021-05-18 12:00:00'), new \DateTime('2021-05-18 16:00:00'));

        self::assertEquals($expectedOutput, $room->canBook($user, $booking));
    }

    public function dataProviderForDuration(): array
    {
        return [

            [new \DateTime('2021-05-18 23:00:00'), new \DateTime('2021-05-19 02:00:00'), true],
            [new \DateTime('2021-05-18 12:00:00'), new \DateTime('2021-05-18 15:59:59'), true],
            [new \DateTime('2021-05-18 12:00:00'), new \DateTime('2021-05-18 16:00:05'), false],
            [new \DateTime('2021-05-18 23:00:00'), new \DateTime('2021-05-18 16:00:01'), false],
        ];
    }

    /**
     * function has to start with Test
     * @dataProvider dataProviderForDuration
     */
    public function testDuration(\DateTime $startDate, \DateTime $endDate, bool $expectedOutput): void
    {
        $room = new Room(false);
        $user = new User(false);
        $booking = new Bookings($user, $room, $startDate, $endDate);

        self::assertEquals($expectedOutput, $room->canBook($user, $booking));

    }

    public function dataProviderForCredit(): array
    {
        return [
            [100, true],
            [8, true],
            [6, false],
        ];
    }

    /**
     * function has to start with Test
     * @dataProvider dataProviderForCredit
     */
    public function testCredit( int $credit, bool $expectedOutput): void
    {
        $room = new Room(false);
        $user = new User(false);
        $user->setCredit($credit);
        $booking = new Bookings($user, $room, new \DateTime('2021-05-18 12:00:00'), new \DateTime('2021-05-18 16:00:00'));

        self::assertEquals($expectedOutput, $room->canBook($user, $booking));

    }

    public function dataProviderForAvailable(): array
    {
        return [
            [new \DateTime('2021-05-18 08:00:00'), new \DateTime('2021-05-18 10:00:00'), true],
            [new \DateTime('2021-05-18 11:00:00'), new \DateTime('2021-05-18 13:00:00'), false],
            [new \DateTime('2021-05-18 11:00:00'), new \DateTime('2021-05-18 15:00:00'), false],
            [new \DateTime('2021-05-18 13:00:00'), new \DateTime('2021-05-18 13:30:00'), false],
            [new \DateTime('2021-05-18 13:00:00'), new \DateTime('2021-05-18 15:00:00'), false],
            [new \DateTime('2021-05-18 12:00:00'), new \DateTime('2021-05-18 14:00:00'), false],
            [new \DateTime('2021-05-18 15:00:00'), new \DateTime('2021-05-18 19:00:00'), true],
        ];
    }

    /**
     * function has to start with Test
     * @dataProvider dataProviderForAvailable
     */
    public function testAvailable(\DateTime $startDate, \DateTime $endDate, bool $expectedOutput): void
    {
        $room = new Room(false);
        $user = new User(false);
        $room->addBooking(new Bookings($user, $room, new \DateTime('2021-05-18 12:00:00'), new \DateTime('2021-05-18 14:00:00')));

        $booking = new Bookings($user, $room, $startDate, $endDate);

        self::assertEquals($expectedOutput, $room->canBook($user, $booking));

    }

}
