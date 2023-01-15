<?php

namespace App\Console\Commands;

use App\Http\Controllers\RatchetController;
use Illuminate\Console\Command;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use React\EventLoop\Factory as LoopFactory;
use React\Socket\Server as Reactor;

class StartRatchetServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ratchet:begin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start ratchet server';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
     public function handle()
    {
        $host = env('RATCHET_HOST') ? env('RATCHET_HOST') : 'ws://localhost';
        $port = env('RATCHET_PORT') ? env('RATCHET_PORT') : 8080;
        echo "Ratchet server started on $host:$port \n";
        $loop = LoopFactory::create();
        $socket = new Reactor('0.0.0.0:' . $port, $loop);
        $wsServer = new WsServer(new RatchetController($loop));
        $server = new IoServer(new HttpServer($wsServer), $socket, $loop);
        $wsServer->enableKeepAlive($server->loop, 10);
        $server->run();
    }
}
