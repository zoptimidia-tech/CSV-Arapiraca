<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); echo json_encode(['message' => 'Método não permitido.']); exit; }
if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) { http_response_code(419); echo json_encode(['message' => 'Sessão expirada. Atualize a página e tente novamente.']); exit; }
$name = trim((string)($_POST['name'] ?? '')); $phone = trim((string)($_POST['phone'] ?? '')); $course = trim((string)($_POST['course'] ?? ''));
if (mb_strlen($name) < 3 || mb_strlen($name) > 120) { http_response_code(422); echo json_encode(['message' => 'Informe um nome válido.']); exit; }
$digits = preg_replace('/\D+/', '', $phone);
if (strlen($digits) < 10 || strlen($digits) > 13) { http_response_code(422); echo json_encode(['message' => 'Informe um WhatsApp válido com DDD.']); exit; }
$allowedCourses = ['Pedagogia','Análise e Desenvolvimento de Sistemas','Administração','Nutrição','Ainda não decidi'];
if (!in_array($course, $allowedCourses, true)) { http_response_code(422); echo json_encode(['message' => 'Selecione uma área de interesse.']); exit; }
$lead = [date('c'), preg_replace('/[\r\n,]/', ' ', $name), $digits, $course, !empty($_POST['marketing']) ? 'sim' : 'não'];
$storage = __DIR__ . DIRECTORY_SEPARATOR . 'leads.csv';
if (!file_exists($storage)) file_put_contents($storage, "data,nome,whatsapp,curso,marketing\n", LOCK_EX);
$handle = fopen($storage, 'ab'); fputcsv($handle, $lead); fclose($handle);
$waNumber = '5582999999999'; $message = rawurlencode("Olá, {$name}! Recebi seu cadastro e quero saber mais sobre {$course}.");
echo json_encode(['message' => 'Cadastro recebido! Abrindo o WhatsApp do polo para você continuar o atendimento.', 'whatsapp' => "https://wa.me/{$waNumber}?text={$message}"]); 
