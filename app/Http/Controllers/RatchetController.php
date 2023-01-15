<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Exception;
use React\EventLoop\LoopInterface;
use React\EventLoop\TimerInterface;
use SplObjectStorage;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class RatchetController extends Controller implements MessageComponentInterface
{
    private $loop;
    private $clients;

    /**
     * Store all the connected clients in php SplObjectStorage
     *
     * RatchetController constructor.
     */
    public function __construct(LoopInterface $loop)
    {
        $this->loop = $loop;
        $this->clients = new SplObjectStorage;
    }

    /**
     * Store the connected client in SplObjectStorage
     * Notify all clients about total connection
     *
     * @param ConnectionInterface $conn
     */
    public function onOpen(ConnectionInterface $conn)
    {
        echo "Client connected " . $conn->resourceId . " \n";
        $this->clients->attach($conn);
        foreach ($this->clients as $client) {
            $client->send(json_encode([
                "type" => "socket",
                "msg" => "Total Connected: " . count($this->clients)
            ]));
        }
    }

    /**
     * Remove disconnected client from SplObjectStorage
     * Notify all clients about total connection
     *
     * @param ConnectionInterface $conn
     */
    public function onClose(ConnectionInterface $conn)
    {
        echo "Client left onClose " . $conn->resourceId . " \n";
        $this->clients->detach($conn);
        foreach ($this->clients as $client) {
            $client->send(json_encode([
                "type" => "socket",
                "msg" => "Total Connected: " . count($this->clients)
            ]));
        }
    }

    /**
     * Receive message from connected client
     * Broadcast message to other clients
     *
     * @param ConnectionInterface $from
     * @param string $data
     */
    public function onMessage(ConnectionInterface $from, $data)
    {
        $resource_id = $from->resourceId;
        $data = json_decode($data);
        $type = $data->type;
        switch ($type) {
            case 'chat':
                $user_id = $data->user_id;
                $user_name = $data->user_name;
                $chat_msg = $data->chat_msg;
                $dest_id = $data->dest_id;
                // $response_from = "<span class='text-success'><b>$user_id. $user_name:</b> $chat_msg <span class='text-warning float-right'>" . date('Y-m-d h:i a') . "</span></span><br><br>";
                $response_from = "<div class='message me'><div class='text-main'><div class='text-group me'><div class='text me'><p>$chat_msg</p></div></div><span>".date('Y-m-d h:i a')."</span></div></div>";
                $response_to = "<div class='message'><div class='text-main'><div class='text-group'><div class='text'><p>$chat_msg</p></div></div><span>".date('Y-m-d h:i a')."</span></div></div>";
                // Output
                $from->send(json_encode([
                    "type" => $type,
                    "msg" => $response_from,
                    "user_id" => $user_id,
                    "dest_id" => $dest_id
                ]));

                foreach ($this->clients as $client) {
                    if ($from != $client) {
                        $client->send(json_encode([
                            "type" => $type,
                            "msg" => $response_to,
                            "user_id" => $user_id,
                            "dest_id" => $dest_id
                        ]));
                    }
                }

                // Save to database
                $message = new Message();
                $message->user_id = $user_id;
                $message->name = $user_name;
                $message->message = $chat_msg;
                $message->dest_id = $dest_id;
                $message->save();

                echo "Resource id $resource_id sent $chat_msg \n";
                break;
        }
    }

    /**
     * Throw error and close connection
     *
     * @param ConnectionInterface $conn
     * @param Exception $e
     */
    public function onError(ConnectionInterface $conn, Exception $e)
    {
        echo "Client left onError " . $conn->resourceId . " \n";
        $conn->close();
    }
}
