<?php

namespace Engelsystem\Test\Unit\Models\Shifts;

use Engelsystem\Models\Shifts\Schedule;
use Engelsystem\Models\Shifts\ScheduleShift;
use Engelsystem\Models\Shifts\ShiftType;
use Engelsystem\Test\Unit\Models\ModelTest;

class ScheduleTest extends ModelTest
{
    protected array $data = [
        'url'            => 'https://foo.bar/schedule.xml',
        'name'           => 'Testing',
        'shift_type'     => 1,
        'minutes_before' => 10,
        'minutes_after'  => 10,
    ];

    /**
     * @covers \Engelsystem\Models\Shifts\Schedule::scheduleShifts
     */
    public function testScheduleShifts(): void
    {
        $schedule = new Schedule($this->data);
        $schedule->save();

        (new ScheduleShift(['shift_id' => 1, 'schedule_id' => $schedule->id, 'guid' => 'a']))->save();
        (new ScheduleShift(['shift_id' => 2, 'schedule_id' => $schedule->id, 'guid' => 'b']))->save();
        (new ScheduleShift(['shift_id' => 3, 'schedule_id' => $schedule->id, 'guid' => 'c']))->save();

        $this->assertCount(3, $schedule->scheduleShifts);
    }

    /**
     * @covers \Engelsystem\Models\Shifts\Schedule::shiftType
     */
    public function testShiftType(): void
    {
        $st = new ShiftType(['name' => 'Shift Type', 'description' => '']);
        $st->save();

        $schedule = new Schedule($this->data);
        $schedule->save();
        $schedule->shiftType()->associate($st);

        $this->assertEquals('Shift Type', Schedule::find(1)->shiftType->name);
    }
}
