<?php

declare(strict_types=1);


require_once __DIR__ . '/../services/SupportService.php';



class SupportController
{
    private SupportService $supportService;

    public function __construct()
    {
        $this->supportService = new SupportService();
    }
    public function support(): void
    {
        render('support', 'main', [
            'pageTitle' => 'Support - St. Thomas Events',
        ]);
    }

    public function chatbotRequest(): void
    {
        $userMessage = $_POST['message'] ?? '';



        $response = $this->supportService->generateResponse($userMessage);

        $reply = $response ? $response : 'Sorry, I could not generate a response at this time.';
        $safeReply = htmlspecialchars($reply, ENT_QUOTES, 'UTF-8');

        header('Content-Type: text/html; charset=UTF-8');
        echo '<div class="flex justify-start"><div class="bg-white rounded-lg rounded-bl-none p-3 shadow-sm max-w-xs border border-gray-200"><p class="text-gray-800 text-sm whitespace-pre-wrap overflow-wrap break-words">' . $safeReply . '</p></div></div>';
        exit;
    }

}