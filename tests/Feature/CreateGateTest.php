<?php

namespace Tests\Feature;

use App\Models\Gate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateGateTest extends TestCase
{
    use RefreshDatabase;
    public function test_gates_can_be_created()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $response = $this->post('/gates', [
            'name'=> 'gate name',
            'serial_number'=>'12345GHU76',
            'magic_code'=>'f39d2823-49ef-414a-806f-f855a799f7f8',
            'team_id'=>$user->fresh()->ownedTeams[0]->id
        ]);

        $this->assertCount(1, $user->fresh()->ownedTeams[0]->gates);
        $this->assertEquals('gate name', $user->fresh()->ownedTeams[0]->gates[0]->name);
    }
}
