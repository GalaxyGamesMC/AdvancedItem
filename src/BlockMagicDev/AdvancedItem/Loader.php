<?php

/*
 *
 *  ____  _            _    __  __             _
 * |  _ \| |          | |  |  \/  |           (_)
 * | |_) | | ___   ___| | _| \  / | __ _  __ _ _  ___
 * |  _ <| |/ _ \ / __| |/ / |\/| |/ _` |/ _` | |/ __|
 * | |_) | | (_) | (__|   <| |  | | (_| | (_| | | (__
 * |____/|_|\___/ \___|_|\_\_|  |_|\__,_|\__, |_|\___|
 *                                       __/ |
 *                                      |___/
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author BlockMagicDev
 * @link https://github.com/BlockMagicDev/Advanceditem
 *
 *
*/

declare(strict_types=1);

namespace BlockMagicDev\AdvancedItem;

use BlockMagicDev\AdvancedItem\command\AdvancedItem;
use BlockMagicDev\AdvancedItem\listeners\PlayerChat;
use BlockMagicDev\AdvancedItem\session\SessionManager;
use BlockMagicDev\AdvancedItem\utils\Configuration;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

class Loader extends PluginBase {
	use SingletonTrait;

	public Configuration $config;

	public Configuration $messages;
	/** @var array<string|mixed> $sessions */
	public array $sessions = [];

	protected function onEnable() : void {
		self::setInstance($this);
		$this->getServer()->getCommandMap()->register('advanceditem', new AdvancedItem($this));
		$this->saveResource('config.yml');
		$this->saveResource('messages.yml');
		$this->config = new Configuration($this->getDataFolder() . "config.yml", Configuration::YAML);
		$this->messages = new Configuration($this->getDataFolder() . "messages.yml", Configuration::YAML);
		new PlayerChat($this);
	}

	public static function getSessionManager() : SessionManager {
		return new SessionManager();
	}

	public function reloadAll() : void {
		$this->reloadConfig();
		$this->config->reload();
		$this->messages->reload();
	}
}
