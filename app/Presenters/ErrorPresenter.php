<?php

namespace Chap\Presenters;

use Nette;
use Nette\Application\IResponse;
use Nette\Application\Responses;
use Tracy\ILogger;


class ErrorPresenter implements Nette\Application\IPresenter
{
    use Nette\SmartObject;

	/** @var ILogger */
	private $logger;


	public function __construct(ILogger $logger)
	{
		$this->logger = $logger;
	}


	public function run(Nette\Application\Request $request): IResponse
	{
		$exception = $request->getParameter('exception');

		if ($exception instanceof Nette\Application\BadRequestException) {
			return new Responses\ForwardResponse($request->setPresenterName('Error4xx'));
		}

		$this->logger->log($exception, ILogger::EXCEPTION);
		return new Responses\CallbackResponse(function () {
			require __DIR__ . '/templates/Error/500.phtml';
		});
	}

}
