<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VirtualKey;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateVirtualKeyTest extends TestCase
{
    use RefreshDatabase;

    public function test_virtual_keys_can_be_created()
    {

        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $response = $this->post('/gates', [
            'name'=> 'gate name',
            'serial_number'=>'12345GHU76',
            'magic_code'=>'f39d2823-49ef-414a-806f-f855a799f7f8',
            'team_id'=>$user->fresh()->ownedTeams[0]->id
        ]);

        $response = $this->post('/gates', [
            'name'=> 'gate name',
            'serial_number'=>'12345GHU76',
            'magic_code'=>'f39d2823-49ef-414a-806f-f855a799f7f8',
            'team_id'=>$user->fresh()->ownedTeams[0]->id
        ]);

        $response = $this->post('/api/virtualKeys', [
            'users'=>[
                    [
                        'id'=> $user->fresh()->id,
                        'label'=> 'key opens gate name, gate name'
                    ]
                ],
            'gates'=>[
                $user->fresh()->ownedTeams[0]->gates[0]->id,
                $user->fresh()->ownedTeams[0]->gates[1]->id
            ],
            'validDays'=>'MTWRF',
        ]);

        $this->assertDatabaseHas('virtual_keys', [
            'label'=> 'Key opens gate name, gate name',
            'user_id'=>$user->fresh()->id,
            'valid_days'=>'MTWRF',
        ]);
    }

    public function test_virtual_keys_can_create_many_to_many_reletionship(){
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $response = $this->post('/gates', [
            'name'=> 'gate name',
            'serial_number'=>'12345GHU76',
            'magic_code'=>'f39d2823-49ef-414a-806f-f855a799f7f8',
            'team_id'=>$user->fresh()->ownedTeams[0]->id
        ]);

        $response = $this->post('/gates', [
            'name'=> 'gate name',
            'serial_number'=>'12345GHU76',
            'magic_code'=>'f39d2823-49ef-414a-806f-f855a799f7f8',
            'team_id'=>$user->fresh()->ownedTeams[0]->id
        ]);

        $response = $this->post('/api/virtualKeys', [
            'users'=>[
                [
                    'id'=> $user->fresh()->id,
                    'label'=> 'key opens gate name, gate name'
                ]
            ],
            'gates'=>[
                $user->fresh()->ownedTeams[0]->gates[0]->id,
                $user->fresh()->ownedTeams[0]->gates[1]->id
            ],
            'validDays'=>'MTWRF',
        ]);

        $this->assertDatabaseHas('gate_virtual_key', [
            'gate_id' => $user->fresh()->ownedTeams[0]->gates[1]->id,
            'virtual_key_id' => 2
        ]);
    }
}
