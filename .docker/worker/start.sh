#!/bin/bash

STATUS_CODE=$(curl -s -o /dev/null -w "%{http_code}" -u guest:guest http://invoicer-rabbitmq:15672/api/overview)

if [ $STATUS_CODE -eq 200 ]
then
    ./bin/console messenger:consume-message amqp
fi

COUNTER=0
while [  $COUNTER -lt 3 ]; do
    sleep 5
    STATUS_CODE=$(curl -s -o /dev/null -w "%{http_code}" -u guest:guest http://invoicer-rabbitmq:15672/api/overview)
    if [ $STATUS_CODE -eq 200 ]
    then
        ./bin/console messenger:consume-message amqp
    fi
    let COUNTER=COUNTER+1
done

echo 'Could not connect to RabbitMQ, status code: ' $STATUS_CODE
exit 1