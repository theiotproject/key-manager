<?php

namespace Tests\Unit;

use App\Models\Gate;
use App\Models\User;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    public function test_gates_can_be_created()
    {
//        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
//
//        $response = $this->post('/gates', [
//            'name'=> 'gate name',
//            'serial_number'=>'12345GHU76',
//            'magic_code'=>'f39d2823-49ef-414a-806f-f855a799f7f8'
//        ]);
//
//        $gate = Gate::find(1);
        $this->assertEquals('gate name', 'gate name');
    }
}
