<?php

namespace App\Console\Commands\User;

use App\Entity\User;
use App\UseCases\Auth\RegisterService;
use Illuminate\Console\Command;

class VerifyCommand extends Command
{
    protected $signature = 'user:verify {email}';
    protected $description = 'Activate User [param email]';

    private $service;

    public function __construct(RegisterService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    public function handle(): bool
    {
        $email = $this->argument('email');

        if (!$user = User::where('email', $email)->first()) {
            $this->error('Undefined user with email ' . $email);
            return false;
        }

        try {
            $this->service->verify($user->id);
            $this->info('Successfully activated');
        } catch (\DomainException $e) {
            $this->warn($e->getMessage());
            return false;
        }

        return true;
    }
}
