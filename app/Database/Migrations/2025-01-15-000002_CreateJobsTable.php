<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJobsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'client_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'service_type' => [
                'type' => 'ENUM',
                'constraint' => ['plumbing', 'electrical', 'cleaning', 'landscaping', 'hvac', 'general'],
            ],
            'address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'scheduled_date' => [
                'type' => 'DATE',
            ],
            'scheduled_time' => [
                'type' => 'TIME',
            ],
            'estimated_duration' => [
                'type' => 'DECIMAL',
                'constraint' => '4,2',
                'null' => true,
            ],
            'actual_duration' => [
                'type' => 'DECIMAL',
                'constraint' => '4,2',
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['scheduled', 'in_progress', 'completed', 'cancelled'],
                'default' => 'scheduled',
            ],
            'priority' => [
                'type' => 'ENUM',
                'constraint' => ['low', 'medium', 'high', 'urgent'],
                'default' => 'medium',
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'before_photos' => [
                'type' => 'JSON',
                'null' => true,
            ],
            'after_photos' => [
                'type' => 'JSON',
                'null' => true,
            ],
            'price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('client_id');
        $this->forge->addKey(['scheduled_date', 'scheduled_time']);
        $this->forge->addKey('status');
        $this->forge->addKey('service_type');
        $this->forge->addForeignKey('client_id', 'clients', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('jobs');
    }

    public function down()
    {
        $this->forge->dropTable('jobs');
    }
}