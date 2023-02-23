<?php declare(strict_types=1);

namespace RunAsRoot\MessageQueueRetry\Api\Data;

interface MessageInterface
{
    public CONST TABLE_NAME = 'run_as_root_dead_letter_queue_message';
    public CONST ENTITY_ID = 'entity_id';
    public CONST TOPIC_NAME = 'topic_name';
    public CONST MESSAGE_BODY = 'message_body';
    public CONST FAILURE_DESCRIPTION = 'failure_description';
    public CONST RESOURCE_ID = 'resource_id';
    public CONST TOTAL_RETRIES = 'total_retries';
    public CONST CREATED_AT = 'created_at';

    public function getTopicName(): string;
    public function setTopicName(string $value): void;

    public function getMessageBody(): string;
    public function setMessageBody(string $value): void;

    public function getFailureDescription(): string;
    public function setFailureDescription(string $value): void;

    public function getResourceId(): string;
    public function setResourceId(string $value): void;

    public function getTotalRetries(): int;
    public function setTotalRetries(int $value): void;

    public function getCreatedAt(): string;
    public function setCreatedAt(string $value): void;
}
