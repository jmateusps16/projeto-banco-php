<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ParagonIE\HiddenString\HiddenString;
use ParagonIE\Halite\KeyFactory;
use ParagonIE\Halite\Symmetric\Crypto as Symmetric;
use App\Repository\PapeisRepository;
use App\Entity\Papeis;

class BaseController extends AbstractController {
   
    protected function GetJsonData(Request $request): array {
        if ($request->getContentTypeFormat() === 'json') {
            try {
                return json_decode($request->getContent(), true) ?? [];
            }
            
            catch (\Throwable) {
                return [];
            }
        }
        else 
            return [];
    }

    protected function getDataOfJsonUsingKey(array $json, string $key, $defaultValue) {
        if (key_exists($key, $json))
            return $json[$key];
        else
            return $defaultValue;
    }

    protected function ResponseJson(array $json, int $statusCode): Response {
        $content = json_encode($json);
        return new Response($content, $statusCode, [ "Content-type" => "application/json", "Content-Length" => strlen($content) ]);
    }

    private function getKey() {
        return KeyFactory::deriveEncryptionKey(new HiddenString($this->getParameter('app.secret')), "\xdd\x7b\x1e\x38\x75\x9f\x72\x86\x0a\xe9\xc8\x58\xf6\x16\x0d\x3b");
    }

    protected function encrypt (string $value): string {
        return Symmetric::encrypt(new HiddenString($value), $this->getKey());
    }

    protected function decrypt (string $value): string {
        return Symmetric::decrypt($value, $this->getKey())->getString();
    }

    protected function IsAdmin(PapeisRepository $papRepository) : bool {
        if ($this->user == null) return false;        
        $papers = $papRepository->findById([ 'credential_id' => $this->user->getId() ]);

        return count(
            array_filter(
                $papers, 
                function (Papeis $value) {
                    return ($value->getCodigoPapel() == 1); // admin
                }
            )
        ) > 0;
    }

    protected function IsManager(PapeisRepository $papRepository) : bool {
        if ($this->user == null) return false;
        $papers = $papRepository->findById([ 'credential_id' => $this->user->getId() ]);

        return count(
            array_filter(
                $papers, 
                function (Papeis $value) {
                    return ($value->getCodigoPapel() == 2); // gerente
                }
            )
        ) > 0;
    }
}